<?php

namespace Gravity_Forms\Gravity_Forms_Square\Subscriptions;

defined( 'ABSPATH' ) || die();

/**
 * Gravity Forms Square Subscription.
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Subscription {

	/**
	 * Subscription ID.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $id;

	/**
	 * The ID of the subscription plan.
	 *
	 * @since 1.3
	 *
	 * @var Plan
	 */
	public $plan;

	/**
	 * The ID of the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $customer_id;

	/**
	 * Card ID saved on file for this subscription.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $card_id;

	/**
	 * Subscription constructor.
	 *
	 * @since 1.3
	 *
	 * @param Plan $plan Plan Object.
	 */
	public function __construct( $plan ) {
		$this->plan = $plan;
	}

	/**
	 * Get the subscription amount from the subscription plan.
	 *
	 * @since 1.3
	 *
	 * @return float
	 */
	public function get_amount() {
		return gf_square()->get_amount_import( $this->plan->amount );
	}

	/**
	 * Returns the ID of the subscription.
	 *
	 * @since 1.3
	 *
	 * @return string The subscription ID.
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Load subscription properties from API response.
	 *
	 * @since 1.3
	 *
	 * @param array $response API response array.
	 *
	 * @return Subscription
	 */
	public function load_from_api_response( array $response ) {
		$this->id          = rgar( $response, 'id' );
		$this->card_id     = rgar( $response, 'card_id' );
		$this->customer_id = rgar( $response, 'customer_id' );

		return $this;
	}

}
