<?php
/**
 * Plugin Name: Gravity Forms Square Add-On
 * Plugin URI: https://gravityforms.com
 * Description: Integrates Gravity Forms with Square, enabling end users to purchase goods and services through Gravity Forms.
 * Version: 2.1.0
 * Author: Gravity Forms
 * Author URI: https://gravityforms.com
 * License: GPL-2.0+
 * Text Domain: gravityformssquare
 * Domain Path: /languages
 *
 * ------------------------------------------------------------------------
 * Copyright 2009 - 2023 rocketgenius
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

defined( 'ABSPATH' ) || die();

define( 'GF_SQUARE_VERSION', '2.1.0' );

define( 'GF_SQUARE_MIN_GF_VERSION', '2.3' );

// If Gravity Forms is loaded, bootstrap the Square Add-On.
add_action( 'gform_loaded', array( 'GF_Square_Bootstrap', 'load' ), 5 );

/**
 * Class GF_Square_Bootstrap
 *
 * Handles the loading of the Square Add-On and registers with the Add-On framework.
 *
 * @since 1.0.0
 */
class GF_Square_Bootstrap {

	/**
	 * If the Payment Add-On Framework exists, Square Add-On is loaded.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public static function load() {

		if ( ! method_exists( 'GFForms', 'include_payment_addon_framework' ) ) {
			return;
		}

		require_once 'class-gf-square.php';

		GFAddOn::register( 'GF_Square' );

	}

}

/**
 * Obtains and returns an instance of the GF_Square class.
 *
 * @since  1.0.0
 *
 * @return GF_Square GF_Square object.
 */
function gf_square() {
	return GF_Square::get_instance();
}
