<?php

namespace Gravity_Forms\Gravity_Forms_Square\Subscriptions;

defined( 'ABSPATH' ) || die();

/**
 * Gravity Forms Square Subscription Plan.
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Plan {

	/**
	 * Plan ID.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $id;

	/**
	 * The amount paid every billing cycle.
	 *
	 * @since 1.3
	 *
	 * @var float
	 */
	public $amount;

	/**
	 * The plan name.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The legacy plan name.
	 *
	 * @since 1.6
	 *
	 * @var string
	 */
	public $legacy_name;

	/**
	 * The billing cycle unit (day, week, month, year)
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $cycle_unit;

	/**
	 * The billing cycle length.
	 *
	 * @since 1.3
	 *
	 * @var integer
	 */
	public $cycle_length;

	/**
	 * Setup fee if plan has one.
	 *
	 * @since 1.3
	 *
	 * @var float
	 */
	public $setup_fee = 0;

	/**
	 * Trial length in days.
	 *
	 * @since 1.3
	 *
	 * @var integer
	 */
	public $trial_length = 0;

	/**
	 * Trial price.
	 *
	 * @since 1.3
	 *
	 * @var float
	 */
	public $trial_price = 0;

	/**
	 * Initialize the Plan object from submission data.
	 *
	 * @since 1.3
	 *
	 * @param array $form            GF Form array.
	 * @param array $feed            GF Feed array.
	 * @param array $submission_data GF Submission Data array.
	 * @param array $entry           GF Entry array.
	 *
	 * @return Plan
	 */
	public function init_from_submission( array $form = array(), array $feed = array(), array $submission_data = array(), array $entry = array() ) {
		if ( rgars( $feed, 'meta/billingCycle_length' ) ) {
			$this->name = sprintf(
				'%1$s for %2$s %3$s every %4$s for %5$s %4$s(s)',
				rgars( $feed, 'meta/feedName' ),
				rgars( $submission_data, 'payment_amount' ),
				\GFCommon::get_currency(),
				rgars( $feed, 'meta/billingCycle_unit' ),
				rgars( $feed, 'meta/billingCycle_length' )
			);
			$this->legacy_name = sprintf(
				'%s for %s %s every %s %s(s)',
				rgars( $feed, 'meta/feedName' ),
				rgars( $submission_data, 'payment_amount' ),
				\GFCommon::get_currency(),
				rgars( $feed, 'meta/billingCycle_length' ),
				rgars( $feed, 'meta/billingCycle_unit' )
			);
		} else {
			$this->name = sprintf(
				'%s for %s %s every %s',
				rgars( $feed, 'meta/feedName' ),
				rgars( $submission_data, 'payment_amount' ),
				\GFCommon::get_currency(),
				rgars( $feed, 'meta/billingCycle_unit' )
			);
		}
		$this->amount       = gf_square()->get_amount_export( rgars( $submission_data, 'payment_amount' ) );
		$this->cycle_length = rgars( $feed, 'meta/billingCycle_length' );
		$this->cycle_unit   = rgars( $feed, 'meta/billingCycle_unit' );


		return $this;
	}

	/**
	 * Loads the plan properties from the response returend from Square API.
	 *
	 * @param array $response The response from the API.
	 *
	 * @return Plan
	 */
	public function load_from_api_response( array $response ) {
		$this->id           = rgar( $response, 'id' );
		$this->name         = rgars( $response, 'subscription_plan_data/name' );
		$this->amount       = rgars( $response, 'subscription_plan_data/phases/0/recurring_price_money/amount' );
		$this->cycle_unit   = rgars( $response, 'subscription_plan_data/phases/0/cadence' );
		$this->cycle_length = rgars( $response, 'subscription_plan_data/phases/0/periods' );

		return $this;
	}

	/**
	 * Generates the request body as required by Square API from plan properties.
	 *
	 * @since 1.3
	 *
	 * @return array
	 */
	public function get_api_create_request() {
		return array(
			'name'   => $this->name,
			'phases' => array(
				array(
					'cadence'               => $this->get_cadence(),
					'periods'               => $this->get_period(),
					'recurring_price_money' => array(
						'amount'   => $this->amount,
						'currency' => \GFCommon::get_currency(),
					),
				),
			),
		);
	}

	/**
	 * Converts cycle unit string to the format that is required by the Square API.
	 *
	 * @since 1.3
	 *
	 * @return string The cycle unit in the requird format.
	 */
	private function get_cadence() {
		switch ( $this->cycle_unit ) {
			case 'day':
				$cadence = 'DAILY';
				break;
			case 'week':
				$cadence = 'WEEKLY';
				break;
			case 'month':
				$cadence = 'MONTHLY';
				break;
			case 'year':
				$cadence = 'ANNUAL';
				break;
			default:
				$cadence = 'MONTHLY';
		}

		return $cadence;
	}

	/**
	 * Converts the period to allow for null values for continuous subscriptions.
	 *
	 * @since 1.6
	 *
	 * @return integer|null The cycle length or null if we're not sending it.
	 */
	private function get_period() {

		$period = ( $this->cycle_length ) ? absint( $this->cycle_length ) : null;

		return $period;
	}

}
