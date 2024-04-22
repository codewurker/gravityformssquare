<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Sorted Attribute Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQuerySortedAttribute
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Sorted_Attribute extends Hydration {

	/**
	 * The attribute whose value is used as the sort key.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_name;

	/**
	 * The first attribute value to be returned by the query. Ascending sorts will return only objects with this value or greater, while descending sorts will return only objects with this value or less. If unset, start at the beginning (for ascending sorts) or end (for descending sorts).
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $initial_attribute_value;

	/**
	 * The desired sort order, "ASC" (ascending) or "DESC" (descending).
	 *
	 * @see https://developer.squareup.com/reference/square/enums/SortOrder
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $sort_order = 'ASC';

}
