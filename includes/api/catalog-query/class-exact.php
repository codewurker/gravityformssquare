<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Exact Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryExact
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Exact extends Hydration {

	/**
	 * The name of the attribute to be searched. Matching of the attribute name is exact.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_name;

	/**
	 * The desired value of the search attribute. Matching of the attribute value is case insensitive and can be partial. For example, if a specified value of "sma", objects with the named attribute value of "Small", "small" are both matched.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_value;

}
