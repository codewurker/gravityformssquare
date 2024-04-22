<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Text Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryText
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Text extends Hydration {

	/**
	 * A list of 1, 2, or 3 search keywords. Keywords with fewer than 3 characters are ignored.
	 *
	 * @since 1.3
	 *
	 * @var array Required. Array of strings.
	 */
	public $keywords;

}
