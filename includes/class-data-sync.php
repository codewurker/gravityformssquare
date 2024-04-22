<?php

namespace Gravity_Forms\Gravity_Forms_Square;

defined( 'ABSPATH' ) || die();

use GF_Square;

/**
 * Gravity Forms Data Sync.
 *
 * This class handles syncing data between a Third Party and Gravity Forms.
 *
 * @since     1.3
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2020, Rocketgenius
 */
class Data_Sync {

	/**
	 * Cron Hook name.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	protected $cron_hook;

	/**
	 * Instance of AddOn Class.
	 *
	 * @since 1.3
	 *
	 * @var GF_Square
	 */
	protected $addon;

	/**
	 * Number of successful syncs.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	private $success = 0;

	/**
	 * Number of failed syncs.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	private $failed = 0;

	/**
	 * Number of skipped syncs.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	private $skipped = 0;

	/**
	 * Set cron action and schedule cron.
	 *
	 * @since 1.3
	 *
	 * @param \GFAddOn Addon Class instance.
	 */
	public function __construct( $addon ) {
		// Require a unique hook name.
		if ( ! $this->cron_hook ) {
			return;
		}

		$this->addon = $addon;

		add_action( $this->cron_hook, array( $this, 'cron_sync_data' ) );
	}

	/**
	 * Schedules the cron if not already scheduled.
	 *
	 * @since 1.3
	 *
	 * @param int $time Time to run cron.
	 *
	 * @return bool If cron was scheduled.
	 */
	public function schedule_cron( $time = false ) {
		// Require a cron_hook value.
		if ( ! $this->cron_hook ) {
			return;
		}

		// Don't schedule multiple events.
		if ( wp_get_scheduled_event( $this->cron_hook ) ) {
			return false;
		}

		// Don't start a new event until the previous event has completed.
		if ( $this->is_running() ) {
			return false;
		}

		$first_run = false;

		if ( false === $time ) {
			$time      = time();
			$first_run = true;
		}

		$scheduled = wp_schedule_single_event( $time, $this->cron_hook );

		if ( $first_run && ! $scheduled ) {
			\GFCommon::add_dismissible_message( __( 'There was a problem scheduling the Data Sync cron.', 'gravityformssquare' ), 'gf-data-sync-cron-problem' );
		}

		return $scheduled;
	}

	/**
	 * Clear all scheduled cron events.
	 *
	 * @since 1.3
	 */
	private function clear_schedule() {
		$next = wp_get_scheduled_event( $this->cron_hook );
		if ( $next ) {
			wp_clear_scheduled_hook( $this->cron_hook );
		}
	}

	/**
	 * Set up start of cron event.
	 *
	 * @since 1.3
	 */
	private function start_event() {
		if ( get_option( $this->cron_hook . '_lastrun' ) ) {
			return;
		}

		update_option( $this->cron_hook . '_lastrun', time() );
	}

	/**
	 * Actions at end of cron event.
	 *
	 * @since 1.3
	 */
	private function end_event() {
		$last_run = get_option( $this->cron_hook . '_lastrun' );

		if ( $last_run ) {
			// Log how long it took.
			$this->addon->log_debug( __METHOD__ . '(): Data Sync Complete; Ran for ' . human_time_diff( $last_run ) );
		}

		// Report results of sync.
		$this->addon->log_debug(
			sprintf(
				'%s(): Data Sync Report; %d Success, %d Failed, %d Skipped',
				__METHOD__,
				$this->success,
				$this->failed,
				$this->skipped
			)
		);

		$this->reset_cron( false );
	}

	/**
	 * Allow cron to be manually reset.
	 *
	 * @since 1.3
	 */
	public function reset_cron( $now = true ) {
		// Require a cron_hook value.
		if ( ! $this->cron_hook ) {
			return;
		}

		$this->disable_cron();

		$next_run = time();
		if ( false === $now ) {
			/**
			 * Allows cron delay to be overriden.
			 *
			 * @since 1.3
			 *
			 * @param int $delay The amount of time, in seconds, to delay the next scheduled cron.
			 */
			$next_run += (int) apply_filters( $this->cron_hook . '_delay', DAY_IN_SECONDS );
		}

		$this->schedule_cron( $next_run );
	}

	/**
	 * Disables any current cron.
	 *
	 * @since 1.3
	 */
	public function disable_cron() {
		// Require a cron_hook value.
		if ( ! $this->cron_hook ) {
			return;
		}

		$this->clear_schedule();
		delete_option( $this->cron_hook . '_lastrun' );
	}

	/**
	 * Check to see if cron is running.
	 *
	 * @since 1.3
	 *
	 * @return bool
	 */
	private function is_running() {
		return (bool) get_option( $this->cron_hook . '_lastrun' );
	}

	/**
	 * Perform cron action of data sync.
	 *
	 * @since 1.3
	 */
	public function cron_sync_data() {
		// Require a cron_hook value.
		if ( ! $this->cron_hook ) {
			return;
		}

		$this->start_event();

		foreach ( $this->get_batch() as $item ) {
			$result = $this->sync( $item );

			if ( true === $result ) {
				$this->sync_success( $item );
			} elseif ( false === $result ) {
				$this->sync_failed( $item );
			} else {
				$this->sync_skipped( $item );
			}
		}

		$this->end_event();
	}

	/**
	 * Retrieve a batch of items to sync.
	 *
	 * @since 1.3
	 *
	 * @return array
	 */
	protected function get_batch() {
		return array();
	}

	/**
	 * Sync data for an item.
	 *
	 * @since 1.3
	 *
	 * @param array $item Item to sync.
	 *
	 * @return bool If successful.
	 */
	protected function sync( $item ) {
		return false;
	}

	/**
	 * Action when sync was successful.
	 *
	 * @since 1.3
	 *
	 * @param array $item Item synced.
	 */
	protected function sync_success( $item ) {
		$this->success++;
	}

	/**
	 * Action when sync failed.
	 *
	 * @since 1.3
	 *
	 * @param array $item Item not synced.
	 */
	protected function sync_failed( $item ) {
		$this->failed++;
	}

	/**
	 * Action when sync is skipped.
	 *
	 * @since 1.3
	 *
	 * @param array $item Item skipped.
	 */
	protected function sync_skipped( $item ) {
		$this->skipped++;
	}
}
