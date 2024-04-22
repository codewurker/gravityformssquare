<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Subscriptions;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;
use Gravity_Forms\Gravity_Forms_Square\API\Money;

/**
 * Gravity Forms Square Subscription.
 *
 * @see https://developer.squareup.com/reference/square/subscriptions-api/create-subscription
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Subscription extends Hydration {

	/**
	 * A unique string that identifies this CreateSubscription request. If you do not provide a unique string (or provide an empty string as the value), the endpoint treats each request as independent.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $idempotency_key;

	/**
	 * Subscription ID.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $id;

	/**
	 * The ID of the location the subscription is associated with.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $location_id;

	/**
	 * The ID of the subscription plan.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $plan_id;

	/**
	 * The ID of the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $customer_id;

	/**
	 * The start date of the subscription, in YYYY-MM-DD format. For example, 2013-01-15. If the start date is left empty, the subscription begins immediately.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $start_date;

	/**
	 * The date when the subscription should be canceled, in YYYY-MM-DD format (for example, 2025-02-29). This overrides the plan configuration if it comes before the date the subscription would otherwise end.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $canceled_date;

	/**
	 * The tax to add when billing the subscription. The percentage is expressed in decimal form, using a '.' as the decimal separator and without a '%' sign. For example, a value of 7.5 corresponds to 7.5%.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $tax_percentage;

	/**
	 * A custom price to apply for the subscription. If specified, it overrides the price configured by the subscription plan.
	 *
	 * @since 1.3
	 *
	 * @var Money
	 */
	public $price_override_money;

	/**
	 * The ID of the customer card to charge. If not specified, Square sends an invoice via email.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $card_id;

	/**
	 * The timezone that is used in date calculations for the subscription. If unset, defaults to the location timezone. If a timezone is not configured for the location, defaults to "America/New_York". Format: the IANA Timezone Database identifier for the location timezone.
	 *
	 * @link https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $timezone;

	/**
	 * Sets Price Override.
	 *
	 * @since 1.3
	 *
	 * @param array|Money $price_override
	 */
	public function set_price_override( $price_override ) {
		if ( ! $price_override instanceof Money ) {
			$price_override = new Money( $price_override );
		}
		$this->price_override_money = $price_override;
	}

}
