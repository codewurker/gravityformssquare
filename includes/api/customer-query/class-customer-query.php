<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Customer_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Customer Query for Customer Search.
 *
 * @see https://developer.squareup.com/reference/square/objects/CustomerQuery
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Customer_Query extends Hydration {

	/**
	 * A list of filtering criteria.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CustomerFilter
	 *
	 * @since 1.3
	 *
	 * @var Customer_Filter
	 */
	public $filter;

	/**
	 * Sorting criteria for query results. The default behavior is to sort customers alphabetically by given_name and family_name.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CustomerSort
	 *
	 * @since 1.3
	 *
	 * @var Customer_Sort
	 */
	public $sort;

	/**
	 * Sets the Filter property.
	 *
	 * @since 1.3
	 *
	 * @param array|Customer_Filter $filter
	 */
	public function set_filter( $filter ) {
		if ( ! $filter instanceof Customer_Filter ) {
			$filter = new Customer_Filter( $filter );
		}
		$this->filter = $filter;
	}

	/**
	 * Sets the sort property.
	 *
	 * @since 1.3
	 *
	 * @param array|Customer_Sort $sort
	 */
	public function set_sort( $sort ) {
		if ( ! $sort instanceof Customer_Sort ) {
			$sort = new Customer_Sort( $sort );
		}
		$this->sort = $sort;
	}

}
