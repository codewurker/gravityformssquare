<?php

namespace Gravity_Forms\Gravity_Forms_Square\API;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;
use Gravity_Forms\Gravity_Forms_Square\API\Address;

/**
 * Gravity Forms Square Customer.
 *
 * @see
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Customer extends Hydration {

	/**
	 * The idempotency key for the request.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $idempotency_key;

	/**
	 * Customer ID.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $id;

	/**
	 * The given (i.e., first) name associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $given_name;

	/**
	 * The family (i.e., last) name associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $family_name;

	/**
	 * A business name associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $company_name;

	/**
	 * A nickname for the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $nickname;

	/**
	 * The email address associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $email_address;

	/**
	 * The physical address associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var Address
	 */
	public $address;

	/**
	 * The 11-digit phone number associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $phone_number;

	/**
	 * An optional, second ID used to associate the customer profile with an entity in another system.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $reference_id;

	/**
	 * A custom note associated with the customer profile.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $note;

	/**
	 * The birthday associated with the customer profile, in RFC 3339 format. Year is optional, timezone and times are not allowed.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $birthday;

}
