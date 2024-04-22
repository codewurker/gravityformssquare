<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Customer_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Customer Creation Source for Customer Query.
 *
 * @see https://developer.squareup.com/reference/square/objects/CustomerCreationSourceFilter
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Creation_Source extends Hydration {

	/**
	 * The list of creation sources used as filtering criteria.
	 *
	 * @see https://developer.squareup.com/reference/square/enums/CustomerCreationSource
	 *
	 * @since 1.3
	 *
	 * @var array Array of strings.
	 */
	public $values = array();

	/**
	 * Indicates whether a customer profile matching the filter criteria should be included in the result or excluded from the result.
	 *
	 * @see https://developer.squareup.com/reference/square/enums/CustomerInclusionExclusion
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $rule = 'INCLUDE';

	/**
	 * Set the values property.
	 *
	 * @since 1.3
	 *
	 * @param array $values Values array.
	 */
	public function set_values( array $values ) {
		foreach ( $values as $value ) {
			$this->add_value( $value );
		}
	}

	/**
	 * Add a value to the values property array.
	 *
	 * @since 1.3
	 *
	 * @param string $value Value.
	 */
	public function add_value( $value ) {
		$this->values[] = strtoupper( $value );
	}

	/**
	 * Set the rule property.
	 *
	 * @since 1.3
	 *
	 * @param string $rule Rule.
	 */
	public function set_rule( $rule ) {
		$this->rule = strtoupper( $rule );
	}
}
