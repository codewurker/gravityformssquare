<?php

namespace Gravity_Forms\Gravity_Forms_Square;

defined( 'ABSPATH' ) || die();

/**
 * Gravity Forms Square Subscriptions Data Sync.
 *
 * This class handles syncing subscription data between Square and Gravity Forms.
 *
 * @since     1.3
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2020, Rocketgenius
 */
class Square_Subscriptions_Sync extends Data_Sync {

	/**
	 * Cron Hook name.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	protected $cron_hook = 'gform_square_subscriptions_sync';

	/**
	 * Retrieve a batch of subscriptions to sync.
	 *
	 * @since 1.3
	 *
	 * @return array
	 */
	protected function get_batch() {
		return $this->addon->get_subscriptions_handler()->get_subscriptions();
	}

	/**
	 * Sync subscription data.
	 *
	 * This method updates the local entry data for a subscription based on the data retrieved from Square.
	 *
	 * @since 1.3
	 *
	 * @param array $item Subscription array.
	 *
	 * @return bool|null True when updated, false when update fails, null when no changes.
	 */
	protected function sync( $item ) {
		$subscription = $item;
		$updated      = null;

		// Handle Cancelled Subscription.
		if ( 'CANCELED' === $subscription['status'] ) {
			$this->addon->cancel_subscription( $subscription['gf_entry']['id'], $this->addon->get_feed( $subscription['gf_entry']['feed_id'] ) );
			$updated = true;
		}

		// Sync Paid Until Date.
		if (
			empty( $subscription['gf_entry']['square_paid_until_date'] )
			|| ( $subscription['paid_until_date'] !== $subscription['gf_entry']['square_paid_until_date'] )
		) {
			gform_update_meta( $subscription['gf_entry']['id'], 'square_paid_until_date', $subscription['paid_until_date'] );
			return true;
		}

		return $updated;
	}

	/**
	 * Action when sync was successful.
	 *
	 * @since 1.3
	 *
	 * @param array $item Item synced.
	 */
	protected function sync_success( $item ) {
		// Update item date/time.
		gform_update_meta( $item['gf_entry']['id'], 'date_updated', gmdate( 'Y-m-d H:i:s' ) );
		$this->addon->log_debug( __METHOD__ . '() : Data Sync Successful; Subscription ID: ' . $item['id'] );
		parent::sync_success( $item );
	}

	/**
	 * Add error log entry for failed sync.
	 *
	 * @since 1.3
	 *
	 * @param array $item Item not synced.
	 */
	protected function sync_failed( $item ) {
		$this->addon->log_error( __METHOD__ . '(): Data Sync Failed; ' . print_r( $item, true ) );
		parent::sync_failed( $item );
	}
}
