<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Range Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryRange
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Range extends Hydration {

	/**
	 * The name of the attribute to be searched.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_name;

	/**
	 * The desired minimum value for the search attribute (inclusive).
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $attribute_min_value;

	/**
	 * The desired maximum value for the search attribute (inclusive).
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $attribute_max_value;
}
