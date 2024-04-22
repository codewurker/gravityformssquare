<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Customer_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Customer Text Filter for Customer Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CustomerTextFilter
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Text_Filter extends Hydration {

	/**
	 * Use the exact filter to select customers whose attributes match exactly the specified query.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $exact;

	/**
	 * Use the fuzzy filter to select customers whose attributes match the specified query in a fuzzy manner. When the fuzzy option is used, search queries are tokenized, and then each query token must be matched somewhere in the searched attribute. For single token queries, this is effectively the same behavior as a partial match operation.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $fuzzy;

}
