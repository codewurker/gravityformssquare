<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Customer_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Customer Filter for Customer Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CustomerFilter
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Customer_Filter extends Hydration {

	/**
	 * A filter to select customers based on when they were created.
	 *
	 * @since 1.3
	 *
	 * @var array|TimeRange
	 */
	public $created_at;

	/**
	 * A filter to select customers based on when they were updated.
	 *
	 * @since 1.3
	 *
	 * @var array|TimeRange
	 */
	public $updated_at;

	/**
	 * A filter to select customers by email address visible to the seller. This filter is case insensitive.
	 *
	 * @since 1.3
	 *
	 * @var array|Text_Filter
	 */
	public $email_address;

	/**
	 * A filter to select customers by their phone numbers visible to the seller. This filter is case insensitive.
	 *
	 * @since 1.3
	 *
	 * @var array|Text_Filter
	 */
	public $phone_number;

	/**
	 * A filter to select customers by their reference IDs. This filter is case insensitive.
	 *
	 * @since 1.3
	 *
	 * @var array|Text_Filter
	 */
	public $reference_id;

}
