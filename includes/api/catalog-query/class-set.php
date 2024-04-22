<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Set Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQuerySet
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Set extends Hydration {

	/**
	 * The name of the attribute to be searched. Matching of the attribute name is exact.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_name;

	/**
	 * The desired values of the search attribute. Matching of the attribute values is exact and case insensitive. A maximum of 250 values may be searched in a request.
	 *
	 * @since 1.3
	 *
	 * @var array Required. Array of strings.
	 */
	public $attribute_values;

}
