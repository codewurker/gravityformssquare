<?php

namespace Gravity_Forms\Gravity_Forms_Square\API;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Money.
 *
 * @see https://developer.squareup.com/reference/square/objects/Money
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Money extends Hydration {

	/**
	 * The amount of money, in the smallest denomination of the currency indicated by currency. For example, when currency is USD, amount is in cents. Monetary amounts can be positive or negative. See the specific field description to determine the meaning of the sign in a particular case.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $amount;

	/**
	 * The type of currency, in ISO 4217 format. For example, the currency code for US dollars is USD.
	 *
	 * @link https://developer.squareup.com/reference/square/enums/Currency
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $currency;

	/**
	 * Set amount.
	 *
	 * @since 1.3
	 *
	 * @param int $amount
	 */
	public function set_amount( $amount ) {
		// Convert decimal to whole number.
		if ( is_float( $amount ) ) {
			$amount = (int) $amount * 100;
		}
		$this->amount = $amount;
	}

}
