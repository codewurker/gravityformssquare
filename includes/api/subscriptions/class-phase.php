<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Subscriptions;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;
use Gravity_Forms\Gravity_Forms_Square\API\Money;

/**
 * Gravity Forms Square Subscription Phase.
 *
 * @see https://developer.squareup.com/reference/square/objects/SubscriptionPhase
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Phase extends Hydration {

	/**
	 * The Square-assigned ID of the subscription phase. This field cannot be changed after a SubscriptionPhase is created.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $uid;

	/**
	 * The billing cadence of the phase. For example, weekly or monthly. This field cannot be changed after a SubscriptionPhase is created.
	 *
	 * @link https://developer.squareup.com/reference/square/enums/SubscriptionCadence
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $cadence;

	/**
	 * The number of cadences the phase lasts. If not set, the phase never ends. Only the last phase can be indefinite. This field cannot be changed after a SubscriptionPhase is created.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $periods;

	/**
	 * The amount to bill for each cadence.
	 *
	 * @since 1.3
	 *
	 * @var Money Required.
	 */
	public $recurring_price_money;

	/**
	 * The position this phase appears in the sequence of phases defined for the plan, indexed from 0. This field cannot be changed after a SubscriptionPhase is created.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $ordinal;

	/**
	 * Sets the recurring price.
	 *
	 * @since 1.3
	 *
	 * @param array|Money $recurring_price
	 */
	public function set_recurring_price( $recurring_price ) {
		if ( ! $recurring_price instanceof Money ) {
			$recurring_price = new Money( $recurring_price );
		}

		$this->recurring_price_money = $recurring_price;
	}
}
