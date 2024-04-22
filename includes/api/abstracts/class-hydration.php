<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Abstracts;

defined( 'ABSPATH' ) || die();

/**
 * Gravity Forms Hydration object.
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
abstract class Hydration {

	/**
	 * Hydration constructor.
	 *
	 * @since 1.3
	 *
	 * @param array $data
	 */
	public function __construct( array $data = array() ) {
		$this->hydrate( $data );
	}

	/**
	 * Build Object and set object properties.
	 *
	 * @since 1.3
	 *
	 * @param array $data Array of data to use for hydration.
	 */
	public function hydrate( $data ) {
		foreach ( $data as $key => $value ) {
			if ( method_exists( $this, "set_{$key}" ) ) {
				$this->{ "set_{$key}" }( $value );
				continue;
			}

			if ( ! property_exists( $this, $key ) ) {
				continue;
			}

			$this->$key = $value;
		}
	}

}
