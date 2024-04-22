<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Prefix Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryPrefix
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Prefix extends Hydration {

	/**
	 * The name of the attribute to be searched.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_name;

	/**
	 * The desired prefix of the search attribute value.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $attribute_prefix;

}
