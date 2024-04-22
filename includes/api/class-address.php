<?php

namespace Gravity_Forms\Gravity_Forms_Square\API;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Address.
 *
 * @see https://developer.squareup.com/reference/square/objects/Address
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Address extends Hydration {

	/**
	 * The first line of the address.
	 *
	 * Fields that start with address_line provide the address's most specific details, like street number, street name, and building name. They do not provide less specific details like city, state/province, or country (these details are provided in other fields).
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $address_line_1;

	/**
	 * The second line of the address, if any.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $address_line_2;

	/**
	 * The third line of the address, if any.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $address_line_3;

	/**
	 * The city or town of the address.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $locality;

	/**
	 * A civil region within the address's locality, if any.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $sublocality;

	/**
	 * A civil region within the address's sublocality, if any.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $sublocality_2;

	/**
	 * A civil region within the address's sublocality_2, if any.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $sublocality_3;

	/**
	 * A civil entity within the address's country. In the US, this is the state.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $administrative_district_level_1;

	/**
	 * A civil entity within the address's administrative_district_level_1. In the US, this is the county.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $administrative_district_level_2;

	/**
	 * A civil entity within the address's administrative_district_level_2, if any.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $administrative_district_level_3;

	/**
	 * The address's postal code.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $postal_code;

	/**
	 * The address's country, in ISO 3166-1-alpha-2 format.
	 *
	 * @link https://developer.squareup.com/reference/square/enums/Country
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $country;

	/**
	 * Optional first name when it's representing recipient.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $first_name;

	/**
	 * Optional last name when it's representing recipient.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $last_name;

	/**
	 * Optional organization name when it's representing recipient.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $organization;

}
