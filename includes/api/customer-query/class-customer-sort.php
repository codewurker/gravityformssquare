<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Customer_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Customer Sort for Customer Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CustomerSort
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Customer_Sort extends Hydration {

	/**
	 * Use one or more customer attributes as the sort key to sort searched customer profiles. For example, use creation date (created_at) of customers or default attributes as the sort key.
	 *
	 * @see https://developer.squareup.com/reference/square/enums/CustomerSortField
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $field = 'DEFAULT';

	/**
	 * Indicates the order in which results should be sorted based on the sort field value. Strings use standard alphabetic comparison to determine order. Strings representing numbers are sorted as strings.
	 *
	 * @see https://developer.squareup.com/reference/square/enums/SortOrder
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $order = 'ASC';

	/**
	 * Set the field property.
	 *
	 * @since 1.3
	 *
	 * @param string $field The field.
	 */
	public function set_field( $field ) {
		$this->field = strtoupper( $field );
	}

	/**
	 * Set the order property.
	 *
	 * @since 1.3
	 *
	 * @param string $order The order.
	 */
	public function set_order( $order ) {
		$this->order = strtoupper( $order );
	}
}
