<?php

namespace Gravity_Forms\Gravity_Forms_Square\API;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;
use Gravity_Forms\Gravity_Forms_Square\API\Customer_Query\Customer_Query;

/**
 * Gravity Forms Square Customer Search Object.
 *
 * @see https://developer.squareup.com/reference/square/customers-api/search-customers
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Customer_Search extends Hydration {

	/**
	 * Include the pagination cursor in subsequent calls to this endpoint to retrieve the next set of results associated with the original query.
	 *
	 * @see https://developer.squareup.com/docs/basics/api101/pagination
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $cursor;

	/**
	 * A limit on the number of results to be returned in a single page. The limit is advisory - the implementation may return more or fewer results. If the supplied limit is negative, zero, or is higher than the maximum limit of 100, it will be ignored.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $limit;

	/**
	 * Query customers based on the given conditions and sort order. Calling SearchCustomers without an explicit query parameter will return all customers ordered alphabetically based on given_name and family_name.
	 *
	 * @since 1.3
	 *
	 * @var Customer_Query
	 */
	public $query;

	/**
	 * Sets the Customer Query parameter.
	 *
	 * @since 1.3
	 *
	 * @param array|Customer_Query $query
	 */
	public function set_query( $query ) {
		if ( ! $query instanceof Customer_Query ) {
			$query = new Customer_Query( $query );
		}

		$this->query = $query;
	}
}
