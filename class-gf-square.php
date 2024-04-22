<?php
/**
 * Gravity Forms Square Add-On.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2009 - 2022, Rocketgenius
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Gravity_Forms\Gravity_Forms_Square\Square_Subscriptions_Handler;
use Gravity_Forms\Gravity_Forms_Square\Subscriptions\Subscription;
use Gravity_Forms\Gravity_Forms_Square\Square_Subscriptions_Sync;

// Include the payment add-on framework.
GFForms::include_payment_addon_framework();

/**
 * Gravity Forms Square Add-On.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */
class GF_Square extends GFPaymentAddOn {

	/**
	 * Payment Transaction Type
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	const PAYMENT_TRANSACTION_TYPE = '1';

	/**
	 * Subscription Transaction Type
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	const SUBSCRIPTION_TRANSACTION_TYPE = '2';

	/**
	 * Version of this add-on which requires reauthentication with the API.
	 *
	 * Anytime updates are made to this class that requires a site to reauthenticate Gravity Forms with Square, this
	 * constant should be updated to the value of GFForms::$version.
	 *
	 * @since 1.3
	 *
	 * @see GFForms::$version
	 */
	const LAST_REAUTHENTICATION_VERSION = '1.4';

	/**
	 * Contains an instance of this class, if available.
	 *
	 * @since 1.0.0
	 * @var object $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;

	/**
	 * Defines the version of the Square Add-On.
	 *
	 * @since 1.0.0
	 * @var string $_version Contains the version, defined from square.php
	 */
	protected $_version = GF_SQUARE_VERSION;

	/**
	 * Defines the minimum Gravity Forms version required.
	 *
	 * @since 1.0.0
	 * @var string $_min_gravityforms_version The minimum version required.
	 */
	protected $_min_gravityforms_version = GF_SQUARE_MIN_GF_VERSION;

	/**
	 * Defines the plugin slug.
	 *
	 * @since 1.0.0
	 * @var string $_slug The slug used for this plugin.
	 */
	protected $_slug = 'gravityformssquare';

	/**
	 * Defines the main plugin file.
	 *
	 * @since 1.0.0
	 * @var string $_path The path to the main plugin file, relative to the plugins folder.
	 */
	protected $_path = 'gravityformssquare/square.php';

	/**
	 * Defines the full path to this class file.
	 *
	 * @since 1.0.0
	 * @var string $_full_path The full path.
	 */
	protected $_full_path = __FILE__;

	/**
	 * Defines the URL where this Add-On can be found.
	 *
	 * @since 1.0.0
	 * @var string $_url The URL of the Add-On.
	 */
	protected $_url = 'http://www.gravityforms.com';

	/**
	 * Defines the title of this Add-On.
	 *
	 * @since 1.0.0
	 * @var string $_title The title of the Add-On.
	 */
	protected $_title = 'Gravity Forms Square Add-On';

	/**
	 * Defines the short title of the Add-On.
	 *
	 * @since 1.0.0
	 * @var string $_short_title The short title.
	 */
	protected $_short_title = 'Square';

	/**
	 * Defines if Add-On should use Gravity Forms servers for update data.
	 *
	 * @since 1.0.0
	 * @var bool $_enable_rg_autoupgrade true
	 */
	protected $_enable_rg_autoupgrade = true;

	/**
	 * Square requires monetary amounts to be formatted as the smallest unit for the currency being used e.g. cents.
	 *
	 * @since 1.0.0
	 * @var bool $_requires_smallest_unit true
	 */
	protected $_requires_smallest_unit = true;

	/**
	 * Defines the capability needed to access the Add-On settings page.
	 *
	 * @since 1.0.0
	 * @var    string $_capabilities_settings_page The capability needed to access the Add-On settings page.
	 */
	protected $_capabilities_settings_page = 'gravityforms_square';

	/**
	 * Defines the capability needed to access the Add-On form settings page.
	 *
	 * @since 1.0.0
	 * @var    string $_capabilities_form_settings The capability needed to access the Add-On form settings page.
	 */
	protected $_capabilities_form_settings = 'gravityforms_square';

	/**
	 * Defines the capability needed to uninstall the Add-On.
	 *
	 * @since 1.0.0
	 * @var    string $_capabilities_uninstall The capability needed to uninstall the Add-On.
	 */
	protected $_capabilities_uninstall = 'gravityforms_square_uninstall';

	/**
	 * Defines the capabilities needed for the Square Add-On
	 *
	 * @since 1.0.0
	 * @var    array $_capabilities The capabilities needed for the Add-On
	 */
	protected $_capabilities = array( 'gravityforms_square', 'gravityforms_square_uninstall' );

	/**
	 * Contains an instance of the Square API library, if available.
	 *
	 * @since 1.0
	 *
	 * @var GF_Square_API $api Contains an instance of the Square API library wrapper.
	 */
	protected $api = null;

	/**
	 * Subscriptions_Handler instance.
	 *
	 * @since 1.3
	 *
	 * @var Square_Subscriptions_Handler
	 */
	protected $subscriptions_handler;

	/**
	 * Subscriptions data sync class instance.
	 *
	 * @since 1.3
	 *
	 * @var Square_Subscriptions_Sync
	 */
	private $subscriptions_sync;

	/**
	 * Whether to enable the theme styling or not.
	 *
	 * @since 1.8
	 *
	 * @var bool
	 */
	protected $_enable_theme_layer = true;

	/**
	 * Contains the strings object used to localize the block editor scripts.
	 *
	 * @since 1.8
	 *
	 * @var array $block_strings
	 */
	protected $block_strings = array();

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @since 1.0.0
	 *
	 * @return object GF_Square
	 */
	public static function get_instance() {

		if ( null === self::$_instance ) {
			self::$_instance = new GF_Square();
		}

		return self::$_instance;

	}

	/**
	 * Prevent the class from being cloned
	 *
	 * @since 1.0.0
	 */
	private function __clone() {
		/** Do nothing */
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function scripts() {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		$square_script_url = $this->is_sandbox() ? 'https://sandbox.web.squarecdn.com/v1/square.js' : 'https://web.squarecdn.com/v1/square.js';
		$catch_all_message = wp_strip_all_tags( __( 'An error occurred while processing your request, please try again later.', 'gravityformssquare' ) );
		$square_field      = $this->get_square_card_field( $this->get_current_form() );

		$scripts = array(
			// Square Payment Form script.
			array(
				'handle'    => 'gforms_square_web_payments',
				'src'       => $square_script_url,
				'deps'      => array(),
				'in_footer' => false,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
					array(
						'admin_page' => array( 'block_editor' ),
						'tab'        => $this->_slug,
					),
				),
			),
			// Front end script.
			array(
				'handle'    => 'gform_square_vendor_theme_js',
				'src'       => trailingslashit( $this->get_base_url() ) . "/assets/js/dist/vendor-theme.js",
				'version'   => $this->_version,
				'deps'      => array( 'gforms_square_web_payments' ),
				'in_footer' => true,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
					array(
						'admin_page' => array( 'block_editor' ),
						'tab'        => $this->_slug,
					),
				),
			),
			array(
				'handle'    => 'gforms_square_theme',
				'src'       => $this->get_base_url() . '/assets/js/dist/scripts-theme.js',
				'version'   => $this->_version,
				'deps'      => array( 'jquery', 'gforms_square_web_payments', 'gform_square_vendor_theme_js' ),
				'in_footer' => true,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
					array(
						'admin_page' => array( 'block_editor' ),
						'tab'        => $this->_slug,
					),
				),
				'strings'   => array(
					'no_active_frontend_feed' => wp_strip_all_tags( __( 'The credit card field will initiate once the payment condition is met.', 'gravityformssquare' ) ),
					'requires_name'           => wp_strip_all_tags( __( 'Please enter a full name.', 'gravityformssquare' ) ),
					'cardNumber'              => wp_strip_all_tags( __( 'Please enter a valid card number.', 'gravityformssquare' ) ),
					'cvv'                     => wp_strip_all_tags( __( 'Please enter a valid security code.', 'gravityformssquare' ) ),
					'expirationDate'          => wp_strip_all_tags( __( 'Please enter a valid expiration date.', 'gravityformssquare' ) ),
					'postalCode'              => wp_strip_all_tags( __( 'Please enter a valid zip code.', 'gravityformssquare' ) ),
					'MISSING_CARD_DATA'       => wp_strip_all_tags( __( 'Please fill in all credit card details.', 'gravityformssquare' ) ),
					'UNSUPPORTED_CARD_BRAND'  => wp_strip_all_tags( __( 'Card is not supported.', 'gravityformssquare' ) ),
					'INVALID_APPLICATION_ID'  => $catch_all_message . '1',
					'MISSING_APPLICATION_ID'  => $catch_all_message . '2',
					'TOO_MANY_REQUESTS'       => $catch_all_message . '3',
					'UNAUTHORIZED'            => $catch_all_message . '4',
					'CATCH_ALL'               => $catch_all_message . '5',
					'sca'                     => wp_strip_all_tags( __( 'SCA Verification failed, please try again.', 'gravityformssquare' ) ),
					'gformSquareBlockStrings' => $this->block_strings,
				),
			),
			array(
				'handle'    => 'gform_square_vendor_admin',
				'src'       => trailingslashit( $this->get_base_url() ) . '/assets/js/dist/vendor-admin.js',
				'version'   => $this->_version,
				'deps'      => array(),
				'in_footer' => true,
				'enqueue'   => array(
					array(
						'admin_page' => array( 'form_editor', 'entry_view', 'form_settings', 'plugin_settings' ),
					),
				),
			),
			array(
				'handle'    => 'gform_square_admin',
				'deps'      => array( 'jquery' ),
				'src'       => $this->get_base_url() . '/assets/js/dist/scripts-admin.js',
				'version'   => $this->_version,
				'in_footer' => true,
				'enqueue'   => array(
					array(
						'admin_page' => array( 'form_editor', 'entry_view', 'form_settings', 'plugin_settings' ),
					),
				),
				'strings'   => array(
					'refund'              => wp_strip_all_tags( __( 'Are you sure you want to refund this payment?', 'gravityformssquare' ) ),
					'cancel_subscription' => wp_strip_all_tags( __( 'Are you sure you want to cancel this subscription?', 'gravityformssquare' ) ),
					'paymentDetailsNonce' => wp_create_nonce( 'gfsquare_payment_details_nonce' ),
					'ajaxurl'             => admin_url( 'admin-ajax.php' ),
					'settings_url'        => admin_url( 'admin.php?page=gf_settings&subview=' . $this->get_slug() ),
					'deauth_nonce'        => wp_create_nonce( 'gf_square_deauth' ),
					'mode'                => $this->get_mode(),
					'disconnect'          => array(
						'site'    => wp_strip_all_tags( __( 'Are you sure you want to disconnect from Square for this website?', 'gravitformssquare' ) ),
						'account' => wp_strip_all_tags( __( 'Are you sure you want to disconnect all Gravity Forms sites connected to this Square account?', 'gravitformssquare' ) ),
					),
					'square_receipt_url'        => wp_strip_all_tags( __( 'Square Receipt URL', 'gravityformssquare' ) ),
				),
			),
		);

		return array_merge( parent::scripts(), $scripts );

	}

	/**
	 * Register needed styles.
	 *
	 * @since 1.0.0
	 *
	 * @return array $styles
	 */
	public function styles() {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		$styles = array(
			array(
				'handle'    => 'gforms_square_frontend',
				'src'       => $this->get_base_url() . "/assets/css/dist/theme{$min}.css",
				'version'   => $this->_version,
				'in_footer' => false,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
					array(
						'admin_page' => array( 'block_editor' ),
						'tab'        => $this->_slug,
					),
				),
			),
			array(
				'handle'  => 'gform_square_admin',
				'src'     => $this->get_base_url() . "/assets/css/dist/admin{$min}.css",
				'version' => $this->_version,
				'deps'    => array( 'thickbox' ),
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings', 'form_settings', 'form_editor' ),
						'tab'        => $this->_slug,
					),
				),
			),
		);

		return array_merge( parent::styles(), $styles );

	}

	/**
	 * An array of styles to enqueue.
	 *
	 * @since 1.8
	 *
	 * @param array $form           The current form object.
	 * @param       $ajax
	 * @param array $settings
	 * @param array $block_settings
	 *
	 * @return array|\string[][]
	 */
	public function theme_layer_styles( $form, $ajax, $settings, $block_settings = array() ) {
		$theme_slug = \GFFormDisplay::get_form_theme_slug( $form );

		if ( $theme_slug !== 'orbital' ) {
			return array();
		}

		$base_url = plugins_url( '', __FILE__ );

		return array(
			'foundation' => array(
				array( 'gravity_forms_square_theme_foundation', "$base_url/assets/css/dist/theme-foundation.css" ),
			),
			'framework' => array(
				array( 'gravity_forms_square_theme_framework', "$base_url/assets/css/dist/theme-framework.css" ),
			),
		);
	}

	/**
	 * Conditional for whether or not a form has a Square field.
	 *
	 * @since 1.8
	 *
	 * @param int $form_id The current form ID.
	 *
	 * @return bool
	 */
	public function form_contains_square_field( $form_id ) {
		$form = GFAPI::get_form( $form_id );

		foreach( $form['fields'] as $field ) {
			if ( $field->type === 'square_creditcard' ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Styles to pass to the Square JS widget as part of its CSS properties object.
	 *
	 * @since 1.8
	 *
	 * @param int   $form_id        The current form ID.
	 * @param array $settings       Global Settings.
	 * @param array $block_settings The block settings.
	 *
	 * @return array
	 */
	public function theme_layer_third_party_styles( $form_id, $settings, $block_settings ) {
		if ( ! $this->form_contains_square_field( $form_id ) ) {
			return array();
		}

		$default_settings = \GFForms::get_service_container()->get( \Gravity_Forms\Gravity_Forms\Form_Display\GF_Form_Display_Service_Provider::BLOCK_STYLES_DEFAULTS );
		$applied_settings = wp_parse_args( $block_settings, $default_settings );

		if ( $applied_settings['theme'] !== 'orbital' ) {
			return array();
		}

		/*
        NOTE:
        The Theme Framework CSS API properties with the "--gform-theme" prefix are deprecated, and
        the CSS API properties with the "--gf" prefix are the updated properties.

        Deprecated version (core): 2.8
        End of support version (core): 2.9
        Deprecated version (square): 2.0.1
        */
        if ( version_compare( GFForms::$version, '2.8.0-beta-1', '<' ) ) {
	        return array(
		        '.input-container' => array(
			        'borderColor'  => '--gform-theme-control-border-color',
			        'borderRadius' => '--gform-theme-control-border-radius',
			        'borderWidth'  => '--gform-theme-control-border-width',
		        ),
		        '.input-container.is-error' => array(
			        'borderColor' => '--gform-theme-control-border-color-error',
			        'borderWidth' => '--gform-theme-control-border-width',
		        ),
		        '.input-container.is-focus' => array(
			        'borderColor' => '--gform-theme-control-border-color-focus',
			        'borderWidth' => '--gform-theme-control-border-width',
		        ),
		        '.message-icon' => array(
			        'color' => '--gform-theme-control-description-color',
		        ),
		        '.message-icon.is-error' => array(
			        'color' => '--gform-theme-control-description-color-error',
		        ),
		        '.message-text' => array(
			        'color' => '--gform-theme-control-description-color',
		        ),
		        '.message-text.is-error' => array(
			        'color' => '--gform-theme-control-description-color-error',
		        ),
		        'input' => array(
			        'backgroundColor' => '--gform-theme-control-background-color',
			        'color'           => '--gform-theme-control-color',
			        //'fontFamily'      => '--gform-theme-control-font-family',
			        'fontSize'        => '--gform-theme-control-font-size',
			        'fontWeight'      => '--gform-theme-control-font-weight',
		        ),
		        'input::placeholder' => array(
			        'color' => '--gform-theme-control-placeholder-color',
		        ),
		        'input.is-error' => array(
			        'color' => '--gform-theme-control-color',
		        ),
		        'input.is-focus' => array(
			        'backgroundColor' => '--gform-theme-control-background-color-focus',
			        'color'           => '--gform-theme-control-color-focus',
			        //'fontFamily'      => '--gform-theme-control-font-family',
			        'fontSize'        => '--gform-theme-control-font-size',
			        'fontWeight'      => '--gform-theme-control-font-weight',
		        ),
	        );
        } else {
	        return array(
		        '.input-container' => array(
			        'borderColor'  => '--gf-ctrl-border-color',
			        'borderRadius' => '--gf-ctrl-radius',
			        'borderWidth'  => '--gf-ctrl-border-width',
		        ),
		        '.input-container.is-error' => array(
			        'borderColor' => '--gf-ctrl-border-color-error',
			        'borderWidth' => '--gf-ctrl-border-width',
		        ),
		        '.input-container.is-focus' => array(
			        'borderColor' => '--gf-ctrl-border-color-focus',
			        'borderWidth' => '--gf-ctrl-border-width',
		        ),
		        '.message-icon' => array(
			        'color' => '--gf-ctrl-desc-color',
		        ),
		        '.message-icon.is-error' => array(
			        'color' => '--gf-ctrl-desc-color-error',
		        ),
		        '.message-text' => array(
			        'color' => '--gf-ctrl-desc-color',
		        ),
		        '.message-text.is-error' => array(
			        'color' => '--gf-ctrl-desc-color-error',
		        ),
		        'input' => array(
			        'backgroundColor' => '--gf-ctrl-bg-color',
			        'color'           => '--gf-ctrl-color',
			        //'fontFamily'      => '--gf-ctrl-font-family',
			        'fontSize'        => '--gf-ctrl-font-size',
			        'fontWeight'      => '--gf-ctrl-font-weight',
		        ),
		        'input::placeholder' => array(
			        'color' => '--gf-ctrl-placeholder-color',
		        ),
		        'input.is-error' => array(
			        'color' => '--gf-ctrl-color',
		        ),
		        'input.is-focus' => array(
			        'backgroundColor' => '--gf-ctrl-bg-color-focus',
			        'color'           => '--gf-ctrl-color-focus',
			        //'fontFamily'      => '--gf-ctrl-font-family',
			        'fontSize'        => '--gf-ctrl-font-size',
			        'fontWeight'      => '--gf-ctrl-font-weight',
		        ),
	        );
        }
	}

	// --------------------------------------------------------------------------------------------------------- //
	// ------------------------- Plugin initialization  -------------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Add WordPress minimum requirement to add-on.
	 *
	 * @return array
	 */
	public function minimum_requirements() {
		return array(
			'wordpress' => array(
				'version' => '5.1',
			),
		);
	}

	/**
	 * Try to initialize API and load the Square credit card field.
	 *
	 * @since 1.0.0
	 */
	public function pre_init() {
		parent::pre_init();

		require_once 'includes/class-gf-field-square-creditcard.php';

		// Abstracts.
		require_once 'includes/api/abstracts/class-hydration.php';
		require_once 'includes/api/abstracts/class-catalog-object.php';

		// Catalog Query Objects.
		require_once 'includes/api/catalog-query/class-sorted-attribute.php';
		require_once 'includes/api/catalog-query/class-exact.php';
		require_once 'includes/api/catalog-query/class-set.php';
		require_once 'includes/api/catalog-query/class-prefix.php';
		require_once 'includes/api/catalog-query/class-range.php';
		require_once 'includes/api/catalog-query/class-text.php';
		require_once 'includes/api/catalog-query/class-catalog-query.php';

		// Customer Query Objects.
		require_once 'includes/api/customer-query/class-text-filter.php';
		require_once 'includes/api/customer-query/class-customer-filter.php';
		require_once 'includes/api/customer-query/class-customer-sort.php';
		require_once 'includes/api/customer-query/class-creation-source.php';
		require_once 'includes/api/customer-query/class-customer-query.php';

		// Square API Objects.
		require_once 'includes/api/class-time-range.php';
		require_once 'includes/api/class-address.php';
		require_once 'includes/api/class-money.php';
		require_once 'includes/api/class-customer.php';
		require_once 'includes/api/class-customer-card.php';
		require_once 'includes/api/class-catalog-search.php';
		require_once 'includes/api/class-customer-search.php';

		// Square API Subscription Objects.
		require_once 'includes/api/subscriptions/class-plan.php';
		require_once 'includes/api/subscriptions/class-plan-data.php';
		require_once 'includes/api/subscriptions/class-phase.php';
		require_once 'includes/api/subscriptions/class-subscription.php';

		// Data Sync.
		require_once 'includes/class-data-sync.php';
		require_once 'includes/class-square-subscriptions-sync.php';

		$this->init_data_sync();
	}

	/**
	 * Initialize Square API wrapper.
	 *
	 * Initializes Square API client if credentials exist and are valid
	 * Renews token if it has been more than 6 days since last renewal.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $auth_data    Auth data to be used instead of the stored data in settings.
	 * @param string $custom_mode  Mode to be used instead of the default mode stored in settings.
	 * @param bool   $force_reinit Force initializing the api even if it was initialized before.
	 *
	 * @return bool
	 */
	public function initialize_api( $auth_data = null, $custom_mode = null, $force_reinit = false ) {
		// If the API is already initialized, return true.
		if ( ! is_null( $this->api ) && ! $force_reinit ) {
			return true;
		}

		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;

		// If auth data is not provided and it is not stored, we can't initialize the api.
		if ( ! is_array( $auth_data ) && false === $this->auth_data_exists( $mode ) ) {
			return false;
		}

		// If Square API class does not exist, load Square API wrapper.
		if ( ! class_exists( 'GF_Square_API' ) ) {
			require_once 'includes/class-gf-square-api.php';
		}

		// If we are going to use stored auth tokens, maybe they should be refreshed.
		if ( ! is_array( $auth_data ) ) {
			$this->maybe_renew_token( $mode );
		}

		// Load auth data and instantiate an api wrapper.
		$tokens = is_array( $auth_data ) ? $auth_data : $this->get_auth_data( $mode );
		if ( is_array( $tokens ) && ! empty( $tokens['access_token'] ) ) {
			$this->api = new GF_Square_API( $tokens, $mode, $this );
		} else {
			$this->log_debug( __METHOD__ . '(): Empty auth data; ' . $tokens );
			return false;
		}

		// Check if token is revoked by trying to fetch locations.
		if ( false === $this->api->fetch_locations() ) {
			$this->log_debug( __METHOD__ . '(): Unable to init API; token might have been revoked.' );
			$this->api = null;

			return false;
		}

		return true;
	}

	/**
	 * Initialize Data Sync.
	 *
	 * @since 1.3
	 */
	private function init_data_sync() {
		$this->subscriptions_sync = new Square_Subscriptions_Sync( $this );

		// Schedule or Disable cron.
		if ( $this->is_sync_enabled() ) {
			$this->subscriptions_sync->schedule_cron();
		} else {
			$this->subscriptions_sync->disable_cron();
		}
	}

	/**
	 * Checks if auth data exist.
	 *
	 * @since 1.0.0
	 *
	 * @param string $mode live or sandbox.
	 *
	 * @return bool
	 */
	public function auth_data_exists( $mode = null ) {
		$mode         = is_null( $mode ) ? $this->get_mode() : $mode;
		$auth_setting = $this->get_plugin_setting( 'auth_data' );

		if ( ! is_array( $auth_setting ) || empty( $auth_setting ) ) {
			return false;
		}

		return ! empty( $auth_setting[ $mode ] );
	}

	/**
	 * Get authorization data.
	 *
	 * Retrieves saved auth array that contains access token and refresh token.
	 *
	 * @since 1.0.0
	 *
	 * @param null $custom_mode If we should get auth data for a specific mode other than the default one.
	 *
	 * @return array|null
	 */
	public function get_auth_data( $custom_mode = null ) {
		// decide which auth data do we need, sandbox, live and later feed level modes.
		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		// Get the authentication setting.
		$auth_setting = $this->get_plugin_setting( 'auth_data' );
		// If the authentication token is not set, return null.
		if ( rgblank( $auth_setting ) ) {
			return null;
		}
		$encrypted_auth_data = empty( $auth_setting[ $mode ] ) ? null : $auth_setting[ $mode ];
		if ( is_null( $encrypted_auth_data ) ) {
			return null;
		}

		// Decrypt data.
		$decrypted_auth_data = GFCommon::openssl_decrypt( $encrypted_auth_data, $this->get_encryption_key() );
		$auth_data           = @unserialize( base64_decode( $decrypted_auth_data ) );

		return $auth_data;
	}

	/**
	 * Checks if token should be renewed and tries to renew it.
	 *
	 * @param string $mode live or sandbox.
	 *
	 * @return bool
	 */
	public function maybe_renew_token( $mode ) {

		$auth_data = $this->get_auth_data( $mode );
		if ( ! is_array( $auth_data ) || empty( $auth_data['refresh_token'] ) || empty( $auth_data['date_created'] ) ) {
			$this->log_error( __METHOD__ . '() : empty or corrupt auth data for ' . $mode . ' mode; ' );
			return false;
		}

		if ( time() > ( $auth_data['date_created'] + 3600 * 24 * 6 ) ) {
			$new_auth_data = $this->renew_token( $auth_data['refresh_token'], $mode );
			$token_updated = $this->update_auth_tokens( $new_auth_data, $mode );
			if ( is_wp_error( $token_updated ) ) {
				$this->log_error( __METHOD__ . '(): Failed to renew token; ' . $token_updated->get_error_message() );
			} else {
				$this->log_debug( __METHOD__ . '(): Token renewed for ' . $mode . ' mode' );
				return true;
			}
		}

		return false;
	}

	/**
	 * Renews access token.
	 *
	 * @since 1.0.0
	 *
	 * @param string $refresh_token Refresh token.
	 * @param string $mode live or sandbox.
	 *
	 * @return bool|string
	 */
	public function renew_token( $refresh_token, $mode ) {

		$custom_app = $this->get_plugin_setting( 'custom_app_' . $mode ) === '1';
		if ( ! $custom_app ) {
			// Call the refresh endpoint on Gravity API.
			$args     = array(
				'body' => array(
					'refresh_token' => $refresh_token,
					'mode'          => $mode,
				),
			);
			$response = wp_remote_post(
				$this->get_gravity_api_url( '/auth/square/refresh' ),
				$args
			);

			// Check if the request was successful.
			$response_code = wp_remote_retrieve_response_code( $response );
			if ( $response_code === 200 ) {
				$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
				if ( ! empty( $response_body['auth_payload'] ) ) {
					return $response_body['auth_payload'];
				} else {
					$this->log_error( __METHOD__ . '(): Missing auth_payload; ' . $response );
					return false;
				}
			} else {
				// Log that token could not be renewed.
				$details = wp_remote_retrieve_body( $response );
				$this->log_error( __METHOD__ . '(): Unable to refresh token; ' . $details );
				return false;
			}
		} else {
			$tokens = $this->get_custom_app_tokens( $refresh_token, 'refresh_token', $mode );
			return $tokens;
		}

	}

	/**
	 * Stores auth tokens when we get auth payload from Square.
	 *
	 * @since 1.0.0
	 *
	 * @param string $auth_payload Encoded authorization data.
	 *
	 * @param string $custom_mode live or sandbox.
	 *
	 * @return bool|WP_Error
	 */
	public function update_auth_tokens( $auth_payload, $custom_mode = null ) {

		$settings = $this->get_plugin_settings();
		if ( ! is_array( $settings ) ) {
			$settings = array();
		}
		// Make sure payload contains the required data.
		if ( empty( $auth_payload['access_token'] ) || empty( $auth_payload['refresh_token'] ) || empty( $auth_payload['merchant_id'] ) ) {
			return new WP_Error( '1', esc_html__( 'Missing authentication data.', 'gravityformssquare' ) );
		}

		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		// Try initializing the api and defaulting to a location.
		if ( $this->initialize_api( $auth_payload, $mode, true ) ) {
			$active_locations = $this->api->get_active_locations();
			if ( is_array( $active_locations ) && ! empty( $active_locations ) ) {
				$default_location = $active_locations[0]['value'];
			} else {
				// If not active location that matches the GF currency found, don't update tokens.
				$this->api = null;
				return new WP_Error( '3', esc_html__( 'No locations found. Please confirm your Square locations support credit card processing with a currency matching Gravity Forms settings.', 'gravityformssquare' ) );
			}
		} else {
			// can't initialize auth_data with new tokens !
			return new WP_Error( '4', esc_html__( 'Invalid authentication data.', 'gravityformssquare' ) );
		}

		// Add creation date so we can decide when to renew.
		$auth_payload['date_created'] = time();

		// Encrypt.
		$encrypted_data = GFCommon::openssl_encrypt( base64_encode( serialize( $auth_payload ) ), $this->get_encryption_key() );
		if ( ! empty( $settings['auth_data'] ) ) {
			$auth_data = $settings['auth_data'];
		} else {
			$auth_data = array();
		}
		$auth_data[ $mode ] = $encrypted_data;

		$settings['auth_data'] = $auth_data;
		// If no location selected, set default location.
		if ( empty( $settings[ 'location_' . $mode ] ) ) {
			$settings[ 'location_' . $mode ] = $default_location;
		}

		// Set the API authentication version.
		$settings['reauth_version'] = self::LAST_REAUTHENTICATION_VERSION;

		// Save plugin settings.
		$this->update_plugin_settings( $settings );

		if ( $this->get_plugin_setting( 'custom_app_' . $mode ) === '1' ) {
			$this->log_debug( __METHOD__ . '(): Connected using custom app.' );
		} else {
			$this->log_debug( __METHOD__ . '(): Connected using gravityforms app.' );
		}

		return true;
	}

	/**
	 * Add AJAX callbacks.
	 *
	 * @since 1.0.0
	 */
	public function init_ajax() {
		parent::init_ajax();
		add_action( 'wp_ajax_gfsquare_deauthorize', array( $this, 'ajax_deauthorize' ) );
		add_action( 'wp_ajax_gfsquare_payment_details_action', array( $this, 'ajax_payment_details_action_handler' ) );
	}

	/**
	 * Handles payment details buttons ajax requests.
	 *
	 * Payment details box shows a refund or a capture button depending on the status of the payment.
	 * This method decides which API action is required, and calls the responsible method for executing this action.
	 *
	 * @since 1.3
	 */
	public function ajax_payment_details_action_handler() {
		check_ajax_referer( 'gfsquare_payment_details_nonce', 'nonce' );

		$entry_id = absint( rgpost( 'entry_id' ) );
		$entry    = GFAPI::get_entry( $entry_id );
		if ( ! $this->initialize_api() || is_wp_error( $entry ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Cannot complete request, please contact us for further assistance.', 'gravityformssquare' ) ) );
		}

		$transaction_id = sanitize_text_field( rgpost( 'transaction_id' ) );

		switch ( sanitize_text_field( rgpost( 'api_action' ) ) ) {
			case 'capture':
				$this->handle_entry_details_capture( $entry, $transaction_id );
				break;
			case 'refund':
				$this->handle_entry_details_refund( $entry, $transaction_id );
				break;
			case 'cancel_subscription':
				$this->handle_entry_details_cancel_subscription( $entry, $transaction_id );
				break;
		}
	}

	/**
	 * Revoke token and remove them from Settings.
	 *
	 * @since 1.0.0
	 */
	public function ajax_deauthorize() {
		check_ajax_referer( 'gf_square_deauth', 'nonce' );
		$scope = sanitize_text_field( wp_unslash( empty( $_POST['scope'] ) ? '' : $_POST['scope'] ) );
		$mode  = $this->get_mode();
		// If user is not authorized, exit.
		if ( ! GFCommon::current_user_can_any( $this->_capabilities_settings_page ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Access denied.', 'gravityformssquare' ) ) );
		}

		// If API instance is not initialized, return error.
		if ( ! $this->initialize_api() ) {
			$this->log_error( __METHOD__ . '(): Unable to de-authorize because API is not initialized.' );

			wp_send_json_error();
		}

		if ( $scope === 'account' ) {
			// Call API to revoke access token.
			$custom_app  = $this->get_plugin_setting( 'custom_app_' . $mode ) === '1';
			$merchant_id = $this->api->get_merchant_id();
			if ( ! $custom_app ) {
				$response = wp_remote_get(
					add_query_arg(
						array(
							'merchant_id' => $merchant_id,
							'mode'        => $mode,
						),
						$this->get_gravity_api_url( '/auth/square/deauthorize' )
					)
				);
			} else {
				// Get base OAuth URL.
				$auth_url      = $this->get_square_host_url() . '/oauth2/revoke';
				$client_id     = $this->get_plugin_setting( 'custom_app_id_' . $mode );
				$client_secret = $this->get_plugin_setting( 'custom_app_secret_' . $mode );
				// Prepare OAuth URL parameters.
				$args = array(
					'headers'    => array(
						'Authorization' => 'Client ' . $client_secret,
					),
					'user-agent' => 'Gravity Forms',
					'body'       => array(
						'client_id'   => $client_id,
						'merchant_id' => $merchant_id,
					),
				);
				// Execute request.
				$response = wp_remote_post( $auth_url, $this->add_square_headers( $args ) );
			}

			$response_code = wp_remote_retrieve_response_code( $response );

			if ( $response_code === 200 ) {
				// Log that we revoked the access token.
				$this->log_debug( __METHOD__ . '(): Square access token revoked.' );
			} else {
				// Log that token cannot be revoked.
				$this->log_error( __METHOD__ . '(): Unable to revoke token at Square.' );
				wp_send_json_error( array( 'message' => esc_html__( 'Unable to revoke token at Square.', 'gravityformssquare' ) ) );
				wp_die();
			}
		}

		// Remove access token from settings.
		$settings     = $this->get_plugin_settings();
		$auth_setting = $settings['auth_data'];
		// If the authentication token is not set, nothing to do.
		if ( rgblank( $auth_setting ) ) {
			wp_send_json_success();
		}
		if ( ! empty( $auth_setting[ $mode ] ) ) {
			unset( $auth_setting[ $mode ] );
		}
		$settings['auth_data'] = $auth_setting;

		// Delete location setting.
		if ( ! empty( $settings[ 'location_' . $mode ] ) ) {
			unset( $settings[ 'location_' . $mode ] );
		}

		$this->update_plugin_settings( $settings );

		// Return success response.
		wp_send_json_success();
	}

	/**
	 * Ajax callback to capture a payment authorization.
	 *
	 * @since 1.3
	 *
	 * @param array|WP_Error $entry          The entry details array.
	 * @param string         $transaction_id The transaction ID to capture.
	 */
	private function handle_entry_details_capture( $entry, $transaction_id ) {
		$payment = $this->api->complete_payment( $transaction_id );

		if ( is_wp_error( $payment ) ) {
			$this->log_error( __METHOD__ . '(): ' . $payment->get_error_message() );
			wp_send_json_error( array( 'message' => $payment->get_error_message() ) );
		}

		$payment_details = array(
			'transaction_id' => rgar( $payment, 'id' ),
			'amount'         => $this->get_amount_import( rgars( $payment, 'amount_money/amount' ), rgars( $payment, 'amount_money/currency' ) ),
			'is_success'     => false,
		);

		if ( rgar( $payment, 'status' ) !== 'COMPLETED' ) {
			$this->fail_capture( $entry, array_merge( $payment_details, array( 'type' => 'fail_capture' ) ) );
			wp_send_json_error(
				array(
					'message' => __( 'Payment could not be captured.', 'gravityformssquare' ),
					'type'    => 'fail_capture',
				)
			);
		}

		$this->complete_payment(
			$entry,
			array_merge(
				$payment_details,
				array(
					'type'       => 'complete_payment',
					'is_success' => true,
				)
			)
		);
		wp_send_json_success( $entry['id'] . ' ' . $payment_details['transaction_id'] );
	}


	/**
	 * Refunds a payment.
	 *
	 * @since 1.3
	 *
	 * @param array  $entry          The entry details.
	 * @param string $transaction_id The ID of the transaction.
	 */
	private function handle_entry_details_refund( $entry, $transaction_id ) {
		$entry_id = $this->get_entry_by_transaction_id( $transaction_id );
		$entry    = GFAPI::get_entry( $entry_id );

		if ( is_wp_error( $entry ) ) {
			wp_send_json_error( array( 'message' => __( 'Unable to find entry.', 'gravityformssquare' ) ) );
		}

		// Get payment object to make sure we are connected to same account that was used when entry was created.
		// And to initialize API.
		$payment = $this->get_entry_square_payment( $entry );
		if ( ! $payment ) {
			wp_send_json_error( array( 'message' => __( 'Unable to find payment on Square', 'gravityformssquare' ) ) );
		}

		// Make sure there are no pending refunds on square side that we haven't heard of.
		if ( $this->payment_has_pending_refunds( $payment ) ) {
			wp_send_json_error( array( 'message' => __( 'This payment has a pending refund', 'gravityformssquare' ) ) );
		}

		$refund = $this->api->create_refund( $transaction_id, $payment );
		if ( is_wp_error( $refund ) ) {
			$this->log_error( __METHOD__ . '(): Unable to refund payment; ' . $refund->get_error_message() );
			wp_send_json_error( array( 'message' => $refund->get_error_message() ) );
		}

		// Update entry refunds.
		$refunds = gform_get_meta( $entry['id'], 'square_refunds' );
		if ( empty( $refunds ) ) {
			$refunds = array();
		}
		$refunds[ rgar( $refund, 'id' ) ] = array(
			'id'     => rgar( $refund, 'id' ),
			'status' => rgar( $refund, 'status' ),
			'amount' => rgars( $refund, 'amount_money/amount' ),
		);

		gform_update_meta( $entry['id'], 'square_refunds', $refunds, $entry['form_id'] );
		// Add flag to prevent refunding until this refund request is complete.
		gform_update_meta( $entry_id, 'refund_status', 'pending', $entry['form_id'] );

		wp_send_json_success();
	}

	/**
	 * Cancels a subscription.
	 *
	 * @since 1.3
	 *
	 * @param array  $entry          The entry details.
	 * @param string $transaction_id The ID of the transaction.
	 */
	private function handle_entry_details_cancel_subscription( $entry, $transaction_id ) {
		$cancel_request = $this->get_subscriptions_handler()->cancel_subscription( $entry, $transaction_id );

		if ( is_wp_error( $cancel_request ) ) {
			wp_send_json_error( array( 'message' => $cancel_request->get_error_message() ) );
		}

		wp_send_json_success();
	}

	/**
	 * Checks if a payment has any pending refunds.
	 *
	 * @since 1.3
	 *
	 * @param array $payment
	 *
	 * @return bool
	 */
	private function payment_has_pending_refunds( $payment ) {
		if ( empty( $payment['refund_ids'] ) || ! is_array( $payment['refund_ids'] ) ) {
			return false;
		}

		foreach ( $payment['refund_ids'] as $refund_id ) {
			$refund = $this->api->get_refund( $refund_id );
			if ( is_wp_error( $refund ) ) {
				continue;
			}
			if ( rgar( $refund, 'status' ) === 'PENDING' ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Fires hourly to update payment statuses and check if token should be renewed.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function check_status() {

		// If the plugin has never been configured, no reason to run cron tasks.
		$settings = $this->get_plugin_settings();
		if ( ! $settings ) {
			return;
		}

		// Check access token status for each mode.
		$modes = array( 'live', 'sandbox' );
		foreach ( $modes as $mode ) {
			$this->maybe_renew_token( $mode );
		}

		// Get last time cron ran.
		$last_update = ! empty( $settings['last_cron_time'] ) ? $settings['last_cron_time'] : null;
		// Update last run time.
		$time                       = new DateTime();
		$settings['last_cron_time'] = $time->format( \DateTime::RFC3339 );
		// Update refund statuses.
		$this->sync_refunds( $last_update );
		$this->update_plugin_settings( $settings );

	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Settings --------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Update auth tokens if required.
	 *
	 * @since 1.0.0
	 */
	public function maybe_update_auth_tokens() {

		if ( rgget( 'subview' ) !== $this->get_slug() ) {
			return;
		}

		$tokens_updated = null;
		$code           = sanitize_text_field( rgget( 'code' ) );
		$mode           = sanitize_text_field( rgget( 'mode' ) );
		$custom_app     = $this->get_plugin_setting( 'custom_app_' . $mode ) === '1';
		if ( ! empty( $code ) && ! $this->is_save_postback() ) {
			$state = sanitize_text_field( rgget( 'state' ) );
			if ( false === wp_verify_nonce( $state, 'gf_square_auth' ) ) {
				$tokens_updated = false;
			} else {
				if ( ! $custom_app ) {
					$tokens = $this->get_tokens( $code, $mode );
				} else {
					$tokens = $this->get_custom_app_tokens( $code, 'authorization_code', $mode );
				}
				$tokens_updated = $this->update_auth_tokens( $tokens, $mode );
				if ( false !== $tokens_updated && ! is_wp_error( $tokens_updated ) ) {
					wp_redirect( remove_query_arg( array( 'code', 'mode', 'state' ) ) );
				}
			}
		}

		// If error is provided or couldn't update tokens, Add error message.
		if ( false === $tokens_updated || is_wp_error( $tokens_updated ) || rgget( 'auth_error' ) ) {
			GFCommon::add_error_message( esc_html__( 'Unable to connect your Square account.', 'gravityformssquare' ) );
			// If we have a specific reason why we couldn't update, show it.
			if ( is_wp_error( $tokens_updated ) ) {
				GFCommon::add_error_message( $tokens_updated->get_error_message() );
			}
		}
	}

	/**
	 * Maybe display an admin notice when the site needs to be re-authenticated.
	 *
	 * @since 1.3
	 */
	public function maybe_display_authentication_notice() {
		if ( ! $this->requires_api_reauthentication() ) {
			return;
		}

		$message = sprintf(
			/* translators: 1: reauthentication version number 2: open <a> tag, 3: close </a> tag */
			esc_html__(
				'Gravity Forms Square v%1$s offers new features which require a re-authentication with Square. %2$sPlease disconnect and reconnect%3$s to reauthenticate your site to take advantage of these new features.',
				'gravityformssquare'
			),
			self::LAST_REAUTHENTICATION_VERSION,
			'<a href="' . esc_attr( $this->get_plugin_settings_url() ) . '">',
			'</a>'
		)
		?>

		<div class="gf-notice notice notice-error">
			<p><?php echo wp_kses( $message, array( 'a' => array( 'href' => true ) ) ); ?></p>
		</div>
		<?php
	}

	/**
	 * Check whether this add-on needs to be reauthenticated with the Square API.
	 *
	 * @since 1.3
	 *
	 * @return bool
	 */
	private function requires_api_reauthentication() {
		$settings = $this->get_plugin_settings();

		if ( ! rgar( $settings, 'auth_data' ) ) {
			return false;
		}

		return ! empty( $settings ) && version_compare( rgar( $settings, 'reauth_version' ), self::LAST_REAUTHENTICATION_VERSION, '<' );
	}

	/**
	 * Setup plugin settings fields.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {
		$fields = array(
			array(
				'title'  => esc_html__( 'Account Settings', 'gravityformssquare' ),
				'fields' => array(
					array(
						'name' => 'reauth_version',
						'type' => 'hidden',
					),
					array(
						'label'         => esc_html__( 'Mode', 'gravityformssquare' ),
						'name'          => 'mode',
						'type'          => 'radio',
						'horizontal'    => true,
						'default_value' => 'live',
						'class'         => 'square_mode',
						'choices'       => array(
							array(
								'label' => esc_html__( 'Live', 'gravityformssquare' ),
								'value' => 'live',
							),
							array(
								'label' => esc_html__( 'Sandbox', 'gravityformssquare' ),
								'value' => 'sandbox',
							),
						),
					),
					array(
						'name' => 'auth_button',
						'type' => 'auth_button',
					),
					array(
						'name' => 'auth_data',
						'type' => 'hidden',
					),
					array(
						'name' => 'custom_app_live',
						'type' => 'hidden',
					),
					array(
						'name' => 'custom_app_sandbox',
						'type' => 'hidden',
					),
					array(
						'name' => 'last_cron_time',
						'type' => 'hidden',
					),
					array(
						'name'          => 'sca_testing_check',
						'type'          => 'checkbox',
						'hidden'        => ! $this->initialize_api() || $this->get_mode() != 'sandbox' || GFCommon::get_currency() != 'GBP',
						'default_value' => 1,
						'choices'       => array(
							array(
								'label'         => esc_html__( 'Force SCA testing', 'gravityformssquare' ),
								'name'          => 'sca_testing',
								'default_value' => 1,

							),
						),
					),
					array(
						'name'  => 'errors',
						'label' => '',
						'type'  => 'errors',
					),
				),
			),
		);

		$location_field = array(
			'name'  => 'location_' . $this->get_mode(),
			'label' => esc_html__( 'Business Location', 'gravityformssquare' ),
		);

		if ( $this->square_api_ready() ) {
			// If we can initialize api, set location field type to select.
			$location_field['type']    = 'select';
			$location_field['choices'] = $this->get_location_choices();
			// Add custom app settings hidden fields
			// In case custom app is used, we still need these settings for deauth and refresh.
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_id_' . $this->get_mode(),
				'type' => 'hidden',
			);
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_secret_' . $this->get_mode(),
				'type' => 'hidden',
			);

		} else {
			// API is not initialized yet, hide location.
			$location_field['type'] = 'hidden';
		}

		$fields[0]['fields'][] = $location_field;

		// Decide which location selector to output as hidden.
		// To keep the other mode location stored so when user switches mode user doesn't have to select it again.
		if ( $this->get_mode() == 'sandbox' ) {
			$fields[0]['fields'][] = array(
				'name' => 'location_live',
				'type' => 'hidden',
			);
		} else {
			$fields[0]['fields'][] = array(
				'name' => 'location_sandbox',
				'type' => 'hidden',
			);
		}

		// Decide which custom app settings to output as hidden.
		// To keep the other mode custom app settings stored so when user switches mode user doesn't have to enter it again.
		if ( $this->get_mode() == 'sandbox' ) {
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_id_live',
				'type' => 'hidden',
			);
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_secret_live',
				'type' => 'hidden',
			);
		} else {
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_id_sandbox',
				'type' => 'hidden',
			);
			$fields[0]['fields'][] = array(
				'name' => 'custom_app_secret_sandbox',
				'type' => 'hidden',
			);
		}

		return $fields;
	}

	/**
	 * Generates location field choices.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_location_choices() {

		$locations = array();

		// Make sure api is initialized first.
		if ( $this->initialize_api() ) {
			// Get active locations from API.
			$locations = $this->api->get_active_locations();
		}

		return $locations;
	}

	/**
	 * Generates Auth button settings field.
	 *
	 * @since 1.0.0
	 * @param array $field Field properties.
	 *
	 * @param bool  $echo Display field contents. Defaults to true.
	 *
	 * @return string
	 */
	public function settings_auth_button( $field, $echo = true ) {
		$html = '';
		// If we could initialize api, means we are connected, so show disconnect UI.
		if ( $this->initialize_api() ) {
			$merchant = $this->api->get_merchant_name();
			if ( is_wp_error( $merchant ) ) {
				$this->log_error( __METHOD__ . '(): Unable to retrieve merchant name; ' . $merchant->get_error_message() );
			} else {
				if ( $this->get_setting( 'custom_app_' . $this->get_mode() ) === '1' ) {
					$html = '<p>' . esc_html__( 'Connected to Square using custom app as: ', 'gravityformssquare' ) . '<strong>' . $merchant . '</strong></p>';
				} else {
					$html = '<p>' . esc_html__( 'Connected to Square as: ', 'gravityformssquare' ) . '<strong>' . $merchant . '</strong></p>';
				}
			}

			$button_text = esc_html__( 'Disconnect your Square account', 'gravityformssquare' );
			$html       .= sprintf(
				' <a href="#" class="button gform_square_deauth_button">%1$s</a>',
				$button_text
			);

			$html .= '<div id="deauth_scope">';
			$html .= '<p><label for="deauth_scope0"><input type="radio" name="deauth_scope" value="site" id="deauth_scope0" checked="checked">' . esc_html__( 'Disconnect this site only', 'gravityformssquare' ) . '</label></p>';
			$html .= '<p><label for="deauth_scope1"><input type="radio" name="deauth_scope" value="account" id="deauth_scope1">' . esc_html__( 'Disconnect all Gravity Forms sites connected to this Square account', 'gravityformssquare' ) . '</label></p>';
			$html .= '<p>' . sprintf( ' <a href="#" class="button gform_square_deauth_button" id="gform_square_deauth_button">%1$s</a>', esc_html__( 'Disconnect your Square account', 'gravityformssquare' ) ) . '</p>';
			$html .= '</div>';
		} elseif ( $this->api == null ) {
			$mode = $this->get_mode();
			// If SSL is available, or localhost is being used, display OAuth settings.
			$host_whitelist = array(
				'127.0.0.1',
				'::1',
			);
			$host_url       = empty( $_SERVER['REMOTE_ADDR'] ) ? null : $_SERVER['REMOTE_ADDR'];
			if ( GFCommon::is_ssl() || in_array( $host_url, $host_whitelist ) ) {
				if ( $this->get_setting( 'custom_app_' . $mode ) !== '1' ) {
					// Create Gravity API Square OAuth endpoint URL.
					$settings_url = urlencode( admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug ) );
					$state        = wp_create_nonce( 'gf_square_auth' );
					$auth_url     = add_query_arg(
						array(
							'redirect_to' => $settings_url,
							'state'       => $state,
							'mode'        => $this->get_mode(),
							'license'     => GFCommon::get_key(),
						),
						$this->get_gravity_api_url( '/auth/square' )
					);
					// Connect button markup.
					$button_text    = $this->is_sandbox() ? esc_html__( 'Click here to connect your sandbox Square account', 'gravityformssquare' ) : esc_attr__( 'Click here to connect your live Square account', 'gravityformssquare' );
					$connect_button = sprintf(
						'<a href="%2$s" class="button square-connect" id="gform_square_auth_button" title="%s"></a>',
						$button_text,
						$auth_url
					);

					$custom_app_link = '';
					if ( $this->show_custom_app_settings() ) {
						$custom_app_link = '<p>&nbsp;</p><p>&nbsp;</p><a href="#" id="gform_square_enable_custom_app">' . esc_html__( 'I want to use a custom app.', 'gravityformssquare' ) . ' </a> ';
					}
					/* translators: 1. Open link tag 2. Close link tag */
					$learn_more_message = '<p>' . sprintf( esc_html__( '%1$sLearn more%2$s about connecting with Square.', 'gravityformssquare' ), '<a target="_blank" href="https://docs.gravityforms.com/setting-up-square-add-on/">', '</a>' ) . '</p>';
					$html               = $connect_button . $learn_more_message . $custom_app_link;
				} else {
					$app_id     = $this->get_setting( 'custom_app_id_' . $mode );
					$app_secret = $this->get_setting( 'custom_app_secret_' . $mode );

					ob_start();
					$this->single_setting_row(
						array(
							'name'     => '',
							'type'     => 'text',
							'label'    => esc_html__( 'OAuth Redirect URI', 'gravityformssquare' ),
							'class'    => 'large',
							'value'    => admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug . '&mode=' . $mode ),
							'readonly' => true,
							'onclick'  => 'this.select();',
						)
					);
					// Display custom app ID.
					$this->single_setting_row(
						array(
							'name'  => 'custom_app_id_' . $mode,
							'type'  => 'text',
							'label' => esc_html__( 'App ID', 'gravityformssquare' ),
							'class' => 'medium',
						)
					);

					// Display custom app secret.
					$this->single_setting_row(
						array(
							'name'  => 'custom_app_secret_' . $mode,
							'type'  => 'text',
							'label' => esc_html__( 'App Secret', 'gravityformssquare' ),
							'class' => 'medium',
						)
					);
					$html .= ob_get_clean();
					$html .= '<tr><td></td><td>';
					// Display custom app OAuth button if App ID & Secret exit.
					if ( ! empty( $app_id ) && ! empty( $app_secret ) ) {
						$auth_url = $this->get_square_auth_url( $app_id, $app_secret );
						// Connect button markup.
						$button_text = $this->is_sandbox() ? esc_html__( 'Click here to connect your sandbox Square account', 'gravityformssquare' ) : esc_attr__( 'Click here to connect your live Square account', 'gravityformssquare' );
						$html       .= sprintf(
							'<a href="%2$s" class="button square-connect" id="gform_square_auth_button" title="%s"></a>',
							$button_text,
							$auth_url
						);
					}
					$html .= '<p>&nbsp;</p><p>&nbsp;</p><a href="#" id="gform_square_disable_custom_app">' . esc_html__( 'I do not want to use a custom app.', 'gravityformssquare' ) . ' </a> ';

					$html .= '</td></tr>';
				}
			} else {
				// Show SSL required warning.
				$html  = '<div class="alert_red" id="settings_error">';
				$html .= '<h4>' . esc_html__( 'SSL Certificate Required', 'gravityformssquare' ) . '</h4>';
				/* translators: 1: Open link tag 2: Close link tag */
				$html .= sprintf( esc_html__( 'Make sure you have an SSL certificate installed and enabled, then %1$sclick here to continue%2$s.', 'gravityformssquare' ), '<a href="' . admin_url( 'admin.php?page=gf_settings&subview=gravityformssquare', 'https' ) . '">', '</a>' );
				$html .= '</div>';
			}
		}

		if ( $echo ) {
			echo $html;
		}

		return $html;

	}

	/**
	 * Check if custom app settings should be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function show_custom_app_settings() {

		/**
		 * Allow custom app link to be displayed.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $show_settings Defaults to false, return true to show custom app settings.
		 */
		$show_settings = apply_filters( 'gform_square_show_custom_app_settings', false );

		return $show_settings;
	}

	/**
	 * Generates Errors section on settings page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field Field properties.
	 *
	 * @param bool  $echo Display field contents. Defaults to true.
	 *
	 * @return string
	 */
	public function settings_errors( $field, $echo = true ) {
		// Define variable to avoid notice.
		$html = null;
		if ( ! $this->initialize_api() ) {
			$html = '';
		} else {
			// Show any settings error messages if not a save postback.
			if ( ! $this->square_currency_matches_gf() ) {
				// Show business location required warning.
				$html .= '<div class="alert_red" id="settings_error" >';
				$html .= '<h4>' . esc_html__( 'Currency Mismatch', 'gravityformssquare' ) . '</h4>';
				// Translators: 1. Square Currency, 2. Gravity Forms Currency.
				$html .= '<p>' . sprintf( esc_html__( 'The selected Square business location currency is %1$s while Gravity Forms currency is %2$s, both currencies should match so you can receive payments to this location, please change your Gravity Forms currency setting.', 'gravityformssquare' ), $this->get_selected_location_currency(), GFCommon::get_currency() ) . '</p>';
				$html .= '</div>';
			}
		}

		if ( $echo ) {
			echo $html;
		}

		return $html;
	}

	/**
	 * Define feed settings fields.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function feed_settings_fields() {
		$modified_settings = parent::feed_settings_fields();
		$modified_settings = $this->add_authorize_setting_field( $modified_settings );

		if ( $this->get_subscriptions_handler()->is_subscription_feed( $this->get_current_feed_array() ) ) {
			$modified_settings = $this->remove_unsupported_subscription_settings( $modified_settings );
		}

		return $modified_settings;
	}

	/**
	 * Add the payment authorization feed setting.
	 *
	 * @since 1.3
	 *
	 * @param array $feed_settings Feed setting data.
	 *
	 * @return array
	 */
	private function add_authorize_setting_field( array $feed_settings ) {
		return $this->add_field_after(
			'paymentAmount',
			array(
				'name'    => 'authorizeOnly',
				'label'   => esc_html__( 'Authorize Only', 'gravityformssquare' ),
				'type'    => 'checkbox',
				'tooltip' => '<h6>' . esc_html__( 'Authorize Only', 'gravityformssquare' ) . '</h6>'
							. esc_html__(
								'Enable this option if you would like to only authorize payments when the user submits the form. You will be able to capture the payment by clicking the capture button from the entry details page.',
								'gravityformssquare'
							),
				'choices' => array(
					array(
						'label' => esc_html__( 'Only authorize payment and capture later from entry details page.' ),
						'name'  => 'authorizeOnly',
					),
				),
			),
			$feed_settings
		);
	}

	/**
	 * Removes the setup, trial and recurring times options from feed settings.
	 *
	 * @since 1.3
	 *
	 * @param array $feed_settings Feed setting data.
	 *
	 * @return array Modified feed settings fields
	 */
	private function remove_unsupported_subscription_settings( array $feed_settings ) {
		$feed_settings = $this->remove_field( 'setupFee', $feed_settings );
		$feed_settings = $this->remove_field( 'trial', $feed_settings );
		$feed_settings = $this->remove_field( 'recurringTimes', $feed_settings );

		return $feed_settings;
	}

	/**
	 * Prepare fields for field mapping in feed settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array $fields
	 */
	public function billing_info_fields() {
		$is_subscription = $this->get_subscriptions_handler()->is_subscription_feed( $this->get_current_feed_array() );

		return array(
			array(
				'name'       => 'email',
				'label'      => __( 'Email address', 'gravityformssquare' ),
				'field_type' => array( 'email' ),
				'required'   => $is_subscription,
			),
			array(
				'name'       => 'first_name',
				'label'      => __( 'First Name', 'gravityformssquare' ),
				'field_type' => array( 'name', 'text' ),
				'required'   => $is_subscription,
			),
			array(
				'name'       => 'last_name',
				'label'      => __( 'Last Name', 'gravityformssquare' ),
				'field_type' => array( 'name', 'text' ),
				'required'   => $is_subscription,
			),
			array(
				'name'       => 'address_line1',
				'label'      => __( 'Address', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_line2',
				'label'      => __( 'Address 2', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_city',
				'label'      => __( 'City', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_state',
				'label'      => __( 'State', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_zip',
				'label'      => __( 'Zip', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
			array(
				'name'       => 'address_country',
				'label'      => __( 'Country', 'gravityformssquare' ),
				'field_type' => array( 'address' ),
			),
		);
	}

	/**
	 * Returns the current feed array or an empty array if the current feed can't be retrieved.
	 *
	 * @since 1.3
	 *
	 * @return array
	 */
	private function get_current_feed_array() {
		return is_array( $this->get_current_feed() ) ? $this->get_current_feed() : array();
	}

	/**
	 * Get post payment actions config.
	 *
	 * @since 1.0
	 *
	 * @param string $feed_slug The feed slug.
	 *
	 * @return array
	 */
	public function get_post_payment_actions_config( $feed_slug ) {
		return array(
			'position' => 'before',
			'setting'  => 'conditionalLogic',
		);
	}

	/**
	 *  Remove feed options field.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function option_choices() {
		return array();
	}

	/**
	 * Set feed creation control.
	 *
	 * @since  1.0.0
	 *
	 * @return bool
	 */
	public function can_create_feed() {
		return $this->square_api_ready() && $this->has_square_card_field();
	}

	/**
	 * Get Square field for form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form Form object. Defaults to null.
	 *
	 * @return boolean
	 */
	public function has_square_card_field( $form = null ) {
		// Get form.
		if ( is_null( $form ) ) {
			$form = $this->get_current_form();
		}

		return $this->get_square_card_field( $form ) !== false;
	}

	/**
	 * Gets Square credit card field object.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form The Form Object.
	 *
	 * @return bool|GF_Field_Square_CreditCard The Square field object, if found. Otherwise, false.
	 */
	public function get_square_card_field( $form ) {
		$fields = GFAPI::get_fields_by_type( $form, array( 'square_creditcard' ) );

		return empty( $fields ) ? false : $fields[0];
	}

	/**
	 * Disable feed duplication.
	 *
	 * @since  1.0
	 *
	 * @param int $id Feed ID requesting duplication.
	 *
	 * @return bool
	 */
	public function can_duplicate_feed( $id ) {

		return false;
	}

	/**
	 * Remove the add new button from the title if the form requires a Square credit card field.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function feed_list_title() {
		$form = $this->get_current_form();

		if ( ! $this->has_square_card_field( $form ) ) {
			return $this->form_settings_title();
		}

		return GFFeedAddOn::feed_list_title();
	}

	/**
	 * Get the require Square field message.
	 *
	 * @since 1.0.0
	 *
	 * @return false|string
	 */
	public function feed_list_message() {
		$form = $this->get_current_form();

		// If settings are not yet configured, display default message.
		if ( ! $this->initialize_api() ) {
			return GFFeedAddOn::feed_list_message();
		}

		// If form doesn't have a Square field, display require message.
		if ( ! $this->has_square_card_field( $form ) ) {
			return $this->requires_square_card_message();
		}

		return GFFeedAddOn::feed_list_message();
	}

	/**
	 * The Square settings billing cycle field
	 *
	 * @since 1.6
	 *
	 * @param Object $field The field object.
	 * @param bool   $echo  Whether to echo the markup.
	 *
	 * @return string The markup for the settings field.
	 */
	public function settings_billing_cycle( $field, $echo = true ) {

		$intervals = $this->supported_billing_intervals();
		// get unit so the length drop down is populated with the appropriate numbers for initial load.
		$unit = $this->get_setting( $field['name'] . '_unit' );
		// Length drop down.
		if ( ! $unit ) {
			$first_interval = reset( $intervals );
		} else {
			$first_interval = $intervals[ $unit ];
		}

		$length_field = array(
			'name'    => $field['name'] . '_length',
			'type'    => 'select',
			'choices' => $this->get_numeric_choices(
				$first_interval['min'],
				$first_interval['max']
			),
		);


		// Unit drop down.
		$choices = array();
		foreach ( $intervals as $unit => $interval ) {
			if ( ! empty( $interval ) ) {
				$choices[] = array(
					'value' => $unit,
					'label' => $interval['label'],
				);
			}
		}

		$unit_field = array(
			'name'     => $field['name'] . '_unit',
			'type'     => 'select',
			'onchange' => "loadSquareBillingLength('" . esc_attr( $field['name'] ) . "')",
			'choices'  => $choices,
		);

		$html = sprintf(
			// translators: placeholder 1 is the length of the billing cycle and placeholder 2 is the number of cycles.
			esc_html__( 'Every %1$s for %2$s billing cycles.', 'gravityformssquare' ),
			$this->settings_select( $unit_field, false ),
			$this->settings_select( $length_field, false )
		);

		$html .= "<script type='text/javascript'>var " . $field['name'] . '_intervals = ' . json_encode( $intervals ) . ';</script>';

		if ( $echo ) {
			echo $html;
		}

		return $html;
	}

	/**
	 * Get the numeric choices for the billing cycle field.
	 *
	 * @since 1.6
	 *
	 * @param integer $min The minimum value for the dropdown.
	 * @param integer $max The maximum value for the dropdown.
	 *
	 * @return array An array of possible choices for the dropdown.
	 */
	public function get_numeric_choices( $min, $max ) {
		$choices = array();
		for ( $i = $min; $i <= $max; $i ++ ) {
			$choices[] = array(
				'label' => $i ? $i : 'infinite',
				'value' => $i,
			);
		}

		return $choices;
	}

	/**
	 * Get the supported billing intervals.
	 *
	 * @since 1.6
	 *
	 * @return array The array of billing cycles with their max and min values.
	 */
	public function supported_billing_intervals() {

		$billing_cycles = array(
			'day'   => array(
				'label' => esc_html__( 'day', 'gravityforms' ),
				'min'   => 0,
				'max'   => 365,
			),
			'week'  => array(
				'label' => esc_html__( 'week', 'gravityforms' ),
				'min'   => 0,
				'max'   => 52,
			),
			'month' => array(
				'label' => esc_html__( 'month', 'gravityforms' ),
				'min'   => 0,
				'max'   => 12,
			),
			'year'  => array(
				'label' => esc_html__( 'year', 'gravityforms' ),
				'min'   => 0,
				'max'   => 10,
			),
		);

		return $billing_cycles;
	}

	/**
	 * Display require Square field message.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function requires_square_card_message() {
		$url = add_query_arg(
			array(
				'view'    => null,
				'subview' => null,
			)
		);

		return sprintf( esc_html__( "You must add a Square field to your form before creating a feed. Let's go %1\$sadd one%2\$s!", 'gravityformsquare' ), "<a href='" . esc_url( $url ) . "'>", '</a>' );
	}

	/**
	 * Add supported notification events.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form The form currently being processed.
	 *
	 * @return array|false The supported notification events. False if feed cannot be found within $form.
	 */
	public function supported_notification_events( $form ) {

		// If this form does not have a Square  feed, return false.
		if ( ! $this->has_feed( $form['id'] ) ) {
			return false;
		}

		// Return Square notification events.
		return array(
			'complete_authorization' => esc_html__( 'Payment Authorized', 'gravityformssquare' ),
			'complete_payment'       => esc_html__( 'Payment Completed', 'gravityformssquare' ),
			'fail_payment'           => esc_html__( 'Payment Failed', 'gravityformssquare' ),
			'fail_capture'           => esc_html__( 'Payment Capture Failed', 'gravityformssquare' ),
			'refund_payment'         => esc_html__( 'Payment Refunded', 'gravityformssquare' ),
			'cancel_subscription'    => esc_html__( 'Subscription Cancelled', 'gravityformssquare' ),
		);

	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Frontend --------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Initialize the frontend hooks.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function init() {
		add_filter( 'gform_register_init_scripts', array( $this, 'register_init_scripts' ), 1, 3 );
		add_filter( 'gform_field_content', array( $this, 'add_square_inputs' ), 10, 5 );
		add_filter( 'gform_field_validation', array( $this, 'pre_validation' ), 10, 4 );
		add_filter( 'gform_pre_submission', array( $this, 'populate_credit_card_last_four' ) );
		add_filter(
			'gform_submission_values_pre_save',
			array(
				$this,
				'square_card_submission_value_pre_save',
			),
			10,
			3
		);

		// Replace Merge tags.
		add_filter( 'gform_pre_replace_merge_tags', array( $this, 'replace_merge_tags' ), 10, 7 );

		add_action( 'gform_field_appearance_settings', array( 'GF_Field_Square_CreditCard', 'payment_form_type_settings' ) );
		// Support frontend feeds so JS event will be triggered when we have a valid feed so we can handle it from JS side.
		$this->_supports_frontend_feeds = true;

		parent::init();

	}

	/**
	 * Register Square scripts when displaying form.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form Form object.
	 * @param array $field_values Current field values. Not used.
	 * @param bool  $is_ajax If form is being submitted via AJAX.
	 *
	 * @return void
	 */
	public function register_init_scripts( $form, $field_values, $is_ajax ) {
		// Check if we should enqueue the frontend script.
		if ( ! $this->frontend_script_callback( $form ) ) {
			return;
		}

		$cc_field = $this->get_square_card_field( $form );
		// Prepare JS Square Object arguments.
		$args = array(
			'application_id'     => $this->get_application_id(),
			'location_id'        => $this->get_selected_location_id(),
			'formId'             => $form['id'],
			'isAjax'             => $is_ajax,
			'currency'           => $this->get_selected_location_currency(),
			'is_sandbox'         => $this->is_sandbox(),
			'multi_placeholders' => $cc_field ? $cc_field->get_multi_elements_placeholders() : array(),
			'pageInstance'       => isset( $form['page_instance'] ) ? $form['page_instance'] : 0,

		);

		$this->block_strings = array(
			'formId'        => $form['id'],
			'ccFieldId'     => $cc_field->id,
			'applicationId' => $this->get_application_id(),
			'locationId'    => $this->get_selected_location_id(),
			'pageInstance'  => isset( $form['page_instance'] ) ? $form['page_instance'] : 0,
		);

		// Check SCA testing option.
		$force_sca = $this->get_plugin_setting( 'sca_testing' );
		if ( ( is_null( $force_sca ) || $force_sca == 1 ) && $this->get_mode() == 'sandbox' && GFCommon::get_currency() == 'GBP' ) {
			$args['forceSCA'] = true;
		} else {
			$args['forceSCA'] = false;
		}

		// Get Square field's data.
		$args['ccFieldId']           = $cc_field->id;
		$args['ccPage']              = $cc_field->pageNumber;
		$args['isSinglePaymentForm'] = rgar( $cc_field, 'formType' ) ? rgar( $cc_field, 'formType' ) : 'single';

		// get all Square feeds.
		$feeds = $this->get_feeds_by_slug( $this->_slug, $form['id'] );

		// Default card input style.
		$default_styles = array(
			'boxShadow' => '0px 0px 0px 0px',
			'details'   => array(
				'hidden' => true,
			),
		);

		/**
		 * Filters Square single element card inputStyle object properties.
		 *
		 * Square single element styling is done by providing css-like
		 * properties and their values in an object called inputStyle,
		 * this filters the default styles provided to the card element.
		 *
		 * @since 1.0.0
		 *
		 * @param array $default_styles {
		 *      Array that contains css properties and their values, property names and values should match
		 *      inputStyle documentation here
		 *      https://developer.squareup.com/docs/api/paymentform#datatype-inputstyleobjects
		 * }
		 *
		 * @param string $form_id The id of the form that contains the field.
		 */
		$args['cardStyle'] = apply_filters( 'gform_square_card_style', $default_styles, $form['id'] );

		foreach ( $feeds as $feed ) {
			if ( rgar( $feed, 'is_active' ) === '0' ) {
				continue;
			}

			// Get feed settings to pass them to JS object.
			$feed_settings = array(
				'feedId'          => rgar( $feed, 'id' ),
				'type'            => rgars( $feed, 'meta/transactionType' ),
				'email'           => rgars( $feed, 'meta/billingInformation_email' ),
				'first_name'      => rgars( $feed, 'meta/billingInformation_first_name' ),
				'last_name'       => rgars( $feed, 'meta/billingInformation_last_name' ),
				'address_line1'   => rgars( $feed, 'meta/billingInformation_address_line1' ),
				'address_line2'   => rgars( $feed, 'meta/billingInformation_address_line2' ),
				'address_city'    => rgars( $feed, 'meta/billingInformation_address_city' ),
				'address_state'   => rgars( $feed, 'meta/billingInformation_address_state' ),
				'address_zip'     => rgars( $feed, 'meta/billingInformation_address_zip' ),
				'address_country' => rgars( $feed, 'meta/billingInformation_address_country' ),
			);

			if ( rgars( $feed, 'meta/transactionType' ) === 'product' ) {
				$feed_settings['paymentAmount'] = rgars( $feed, 'meta/paymentAmount' );
			} elseif ( rgars( $feed, 'meta/transactionType' ) === 'subscription' ) {
				$feed_settings['paymentAmount'] = rgars( $feed, 'meta/recurringAmount' );
			}

			$args['feeds'][ $feed['id'] ] = $feed_settings;
		}

		$script = 'new GFSquare( ' . json_encode( $args, JSON_FORCE_OBJECT ) . ' );';

		// Add Square script to form scripts.
		GFFormDisplay::add_init_script( $form['id'], 'square', GFFormDisplay::ON_PAGE_RENDER, $script );
	}

	/**
	 * Check if the form has an active Square feed and a Square credit card field.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form Form object.
	 *
	 * @return bool If the script and style should be enqueued.
	 */
	public function frontend_script_callback( $form ) {
		return $form && $this->has_feed( $form['id'] ) && $this->has_square_card_field( $form );
	}

	/**
	 * Add required Square inputs to form.
	 *
	 * @since  1.0.0
	 *
	 * @param string  $content The field content to be filtered.
	 * @param object  $field   The field that this input tag applies to.
	 * @param string  $value   The default/initial value that the field should be pre-populated with.
	 * @param integer $lead_id When executed from the entry detail screen, $lead_id will be populated with the Entry ID.
	 * @param integer $form_id The current Form ID.
	 *
	 * @return string $content HTML formatted content.
	 */
	public function add_square_inputs( $content, $field, $value, $lead_id, $form_id ) {

		// If this form does not have a Square feed or if this is not a Square field, return field content.
		if ( ! $this->has_feed( $form_id ) || $field->get_input_type() !== 'square_creditcard' ) {
			return $content;
		}

		// Populate Square card data to hidden fields if they exist.

		$square_nonce = sanitize_text_field( rgpost( 'square_nonce' ) );
		if ( $square_nonce ) {
			$content .= '<input type="hidden" name="square_nonce" id="' . $form_id . '_square_nonce" value="' . esc_attr( $square_nonce ) . '" />';
		}

		$square_verification = sanitize_text_field( rgpost( 'square_verification' ) );
		if ( $square_verification ) {
			$content .= '<input type="hidden" name="square_verification" id="' . $form_id . '_square_verification" value="' . esc_attr( $square_verification ) . '" />';
		}

		$square_last_four = sanitize_text_field( rgpost( 'square_credit_card_last_four' ) );
		if ( $square_last_four ) {
			$content .= '<input type="hidden" name="square_credit_card_last_four" id="' . $form_id . '_square_credit_card_last_four" value="' . esc_attr( $square_last_four ) . '" />';
		}

		$square_card_type = sanitize_text_field( rgpost( 'square_credit_card_type' ) );
		if ( $square_card_type ) {
			$content .= '<input type="hidden" name="square_credit_card_type" id="' . $form_id . '_square_credit_card_type" value="' . esc_attr( $square_card_type ) . '" />';
		}

		return $content;

	}

	/**
	 * Handles Square field's custom validation.
	 *
	 * The Square field doesn't have an input, it is just a div that is replaced by
	 * the Square single element payment form this will cause the field to fail standard
	 * validation if marked as required, instead of checking for an input's value we check if we
	 * have a nonce.
	 *
	 * @since  1.0.0
	 *
	 * @param array    $result The field validation result and message.
	 * @param mixed    $value The field input values.
	 * @param array    $form The Form currently being processed.
	 * @param GF_Field $field The field currently being processed.
	 *
	 * @return array $result The results of the validation.
	 */
	public function pre_validation( $result, $value, $form, $field ) {
		if ( $field->type === 'square_creditcard' && $field->isRequired && empty( rgpost( 'square_nonce' ) ) ) {
			$result['is_valid'] = false;
			$result['message']  = esc_html__( 'Missing credit card information', 'gravityformssquare' );
		}

		return $result;

	}

	/**
	 * Populate the $_POST with the last four digits of the card number and card type.
	 *
	 * @since  1.0.0
	 *
	 * @param array $form Form object.
	 */
	public function populate_credit_card_last_four( $form ) {

		if ( ! $this->is_payment_gateway || ! $this->has_square_card_field( $form ) ) {
			return;
		}

		$cc_field                                 = $this->get_square_card_field( $form );
		$last_four                                = sanitize_text_field( rgpost( 'square_credit_card_last_four' ) );
		$card_type                                = sanitize_text_field( rgpost( 'square_credit_card_type' ) );
		$_POST[ 'input_' . $cc_field->id . '_1' ] = 'XXXXXXXXXXXX' . $last_four;
		$_POST[ 'input_' . $cc_field->id . '_2' ] = $card_type;

	}

	/**
	 * Replace Square merge tags.
	 *
	 * @since 2.1.0
	 *
	 * @param string $text       The text which may contain merge tags to be processed.
	 * @param array  $form       The current form.
	 * @param array  $entry      The current entry.
	 * @param bool   $url_encode Indicates if the replacement value should be URL encoded.
	 * @param bool   $esc_html   Indicates if HTML found in the replacement value should be escaped.
	 * @param bool   $nl2br      Indicates if newlines should be converted to html <br> tags.
	 * @param string $format     Determines how the value should be formatted. HTML or text.
	 *
	 * @return string
	 */
	public function replace_merge_tags( $text, $form, $entry, $url_encode = false, $esc_html = true, $nl2br = true, $format = 'html' ) {
		if ( preg_match_all( '/\{square_receipt_url\}/m', $text ) ) {
			$text = $this->replace_square_receipt_url_merge_tag( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format );
		}

		return $text;
	}

	/**
	 * Replaces the Square receipt URL merge tag.
	 *
	 * @since 2.1.0
	 *
	 * @param string $text       The text which may contain merge tags to be processed.
	 * @param array  $form       The current form.
	 * @param array  $entry      The current entry.
	 * @param bool   $url_encode Indicates if the replacement value should be URL encoded.
	 * @param bool   $esc_html   Indicates if HTML found in the replacement value should be escaped.
	 * @param bool   $nl2br      Indicates if newlines should be converted to html <br> tags.
	 * @param string $format     Determines how the value should be formatted. HTML or text.
	 *
	 * @return string
	 */
	public function replace_square_receipt_url_merge_tag( $text, $form, $entry, $url_encode = false, $esc_html = true, $nl2br = true, $format = 'html' ) {
		preg_match_all( '/\{square_receipt_url\}/m', $text, $matches, PREG_SET_ORDER, 0 );
		$receipt_url = gform_get_meta( rgar( $entry, 'id' ), 'square_receipt_url' );
		$entry_mode  = gform_get_meta( rgar( $entry, 'id' ), 'square_mode' );
		// Receipt URLs are do not work in sandbox mode, redirect to docs site to explain that.
		if ( $entry_mode === 'sandbox' ) {
			$receipt_url = 'https://docs.gravityforms.com/square_receipt_url-merge-tag/';
		}

		foreach ( $matches as $match ) {
			$text = str_replace( $match[0], $receipt_url, $text );
		}

		return $text;
	}

	/**
	 * Allows the modification of submitted values of the Square field before the draft submission is saved.
	 *
	 * @since 1.0.0
	 *
	 * @param array $submitted_values The submitted values.
	 * @param array $form The Form object.
	 *
	 * @return array
	 */
	public function square_card_submission_value_pre_save( $submitted_values, $form ) {
		foreach ( $form['fields'] as $field ) {
			if ( $field->type == 'square_creditcard' ) {
				unset( $submitted_values[ $field->id ] );
			}
		}

		return $submitted_values;
	}

	/**
	 * Gets the payment validation result.
	 *
	 * @since  1.0.0
	 *
	 * @param array $validation_result Contains the form validation results.
	 * @param array $authorization_result Contains the form authorization results.
	 *
	 * @return array The validation result for the credit card field.
	 */
	public function get_validation_result( $validation_result, $authorization_result ) {
		if ( empty( $authorization_result['error_message'] ) ) {
			return $validation_result;
		}

		$credit_card_page = 0;
		foreach ( $validation_result['form']['fields'] as &$field ) {
			if ( $field->type === 'square_creditcard' ) {
				$field->failed_validation  = true;
				$field->validation_message = $authorization_result['error_message'];
				$credit_card_page          = $field->pageNumber;
				break;
			}
		}

		$validation_result['credit_card_page'] = $credit_card_page;
		$validation_result['is_valid']         = false;

		return $validation_result;
	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Transactions ----------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Initialize authorizing the transaction for the product.
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array Authorization and transaction ID if authorized. Otherwise, exception.
	 */
	public function authorize( $feed, $submission_data, $form, $entry ) {
		// Check API is ready before starting any transactions.
		if ( false === $this->square_api_ready( true ) ) {
			$this->log_error( __METHOD__ . '(): Square API could not be loaded' );
			return $this->authorization_error( esc_html__( 'Please check your Square API settings', 'gravityformssquare' ) );
		}

		return $this->authorize_product( $feed, $submission_data, $form, $entry );
	}

	/**
	 * Create the Square payment and return any authorization errors which occur.
	 *
	 * @since  1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array Authorization and transaction ID if authorized. Otherwise, exception.
	 */
	public function authorize_product( $feed, $submission_data, $form, $entry ) {
		// Check that we have nonce otherwise return an error.
		$square_nonce = sanitize_text_field( rgpost( 'square_nonce' ) );
		if ( rgblank( $square_nonce ) ) {
			return $this->authorization_error( esc_html__( 'Invalid square nonce', 'gravityformssquare' ) );
		}
		// Get main payment information.
		$currency    = $this->get_selected_location_currency();
		$amount      = $this->get_amount_export( $submission_data['payment_amount'], $currency );
		$location_id = $this->get_selected_location_id();
		// Check amount matches minimum required amount according to location's country.
		if ( false === $this->validate_location_amount( $location_id, $amount ) ) {
			return $this->authorization_error( esc_html__( 'Payment amount is smaller than the allowed amount for this business location', 'gravityformssquare' ) );
		}

		// Build payment data array.
		$payment_data = array(
			'idempotency_key' => $this->api->generate_idempotency_key(),
			'amount_money'    => array(
				'amount'   => $amount,
				'currency' => $currency,
			),
			'source_id'       => $square_nonce,
			'autocomplete'    => false,
			'location_id'     => $location_id,
			'note'            => 'Gravity Forms - ' . $submission_data['form_title'],
		);


		// If the site is using a custom app then send the Integration ID.
		$mode = $this->get_mode();
		if ( $this->get_plugin_setting( 'custom_app_' . $mode ) === '1' ) {
			$payment_data['auxiliary_info'] = array(
				array(
					'key'   => 'integration_id',
					'value' => 'sqi_eccfda4c24614257951d19865a22d601',
				),
			);
		}

		// Add order information if it exists.
		$this->add_order_information( $feed, $entry, $submission_data, $payment_data );

		// Add verification token if it exists.
		$verification = sanitize_text_field( rgpost( 'square_verification' ) );
		if ( ! empty( $verification ) ) {
			$payment_data['verification_token'] = $verification;
		}

		/**
		 * Filters Square payment data.
		 *
		 * @since 1.0.0
		 *
		 * @param array $payment_data {
		 *      Array that contains payment properties and their values as documented in
		 *      https://developer.squareup.com/reference/square/payments-api/create-payment
		 * }
		 *
		 * @param array $feed The feed object currently being processed.
		 * @param array $submission_data The customer and transaction data.
		 * @param array $form The form object currently being processed.
		 * @param array $entry The entry object currently being processed.
		 */
		$payment_data = apply_filters( 'gform_square_payment_data', $payment_data, $feed, $submission_data, $form, $entry );

		// Try to create the payment, return error if we could not, this error will result in a validation error.
		$payment = $this->api->create_payment( $payment_data );

		if ( is_wp_error( $payment ) ) {
			return $this->authorization_error( $payment->get_error_message() );
		}

		return array(
			'is_authorized'  => true,
			'transaction_id' => rgar( $payment, 'id' ),
			'type'           => 'complete_authorization',
			'order_id'       => rgar( $payment, 'order_id' ),
		);
	}

	/**
	 * Extracts billing information from entry if it exists.
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $payment_data The payment data array passed by reference.
	 *
	 * @return void
	 */
	public function add_order_information( $feed, $entry, $submission_data, &$payment_data ) {
		// Add billing to payment.
		$billing_info_mapping = array(
			'billing_address:first_name'     => 'first_name',
			'billing_address:last_name'      => 'last_name',
			'billing_address:address_line_1' => 'address_line1',
			'billing_address:address_line_2' => 'address_line2',
			'billing_address:locality'       => 'address_city',
			'billing_address:administrative_district_level_1' => 'address_state',
			'billing_address:postal_code'    => 'address_zip',
			'billing_address:country'        => 'address_country',
			'buyer_email_address'            => 'email',
		);
		$form = GFAPI::get_form( $feed['form_id'] );
		foreach ( $billing_info_mapping as $square_field => $feed_key ) {
			$field_key   = rgars( $feed, 'meta/billingInformation_' . $feed_key );
			$field_value = $this->get_field_value( $form, $entry, $field_key );
			if ( ! empty( $field_value ) ) {
				if ( $feed_key === 'address_country' ) {
					$field_value = GFCommon::get_country_code( $field_value );
				}
				$keys = explode( ':', $square_field );
				if ( count( $keys ) > 1 ) {
					$payment_data[ $keys[0] ][ $keys[1] ] = $field_value;
				} else {
					$payment_data[ $keys[0] ] = $field_value;
				}
			}
		}

		// Add customer if enough data exist.
		$customer_data                  = array();
		$email_key                      = rgars( $feed, 'meta/billingInformation_email' );
		$customer_data['email_address'] = $this->get_field_value( $form, $entry, $email_key );

		$first_name_key              = rgars( $feed, 'meta/billingInformation_first_name' );
		$customer_data['given_name'] = $this->get_field_value( $form, $entry, $first_name_key );

		$last_name_key                = rgars( $feed, 'meta/billingInformation_last_name' );
		$customer_data['family_name'] = $this->get_field_value( $form, $entry, $last_name_key );

		// Add Address to customer object if address exists.
		if ( ! empty( $payment_data['billing_address'] ) && is_array( $payment_data['billing_address'] ) ) {
			$customer_data['address'] = $payment_data['billing_address'];
		}

		$customer_id = null;
		if ( ! empty( $customer_data['email_address'] ) || ! empty( $customer_data['given_name'] ) || ! empty( $customer_data['family_name'] ) ) {
			$customer_id = $this->api->create_customer( $customer_data );
			if ( ! is_wp_error( $customer_id ) ) {
				$this->log_debug( __METHOD__ . sprintf( '(): Adding customer_id (%s) to payment data.', $customer_id ) );
				$payment_data['customer_id'] = $customer_id;
			} else {
				$this->log_error( __METHOD__ . '(): Could not create customer; ' . $customer_id->get_error_message() );
			}
		}

		// Add Order data.
		$selected_location = $this->get_selected_location_id();
		$currency          = $this->api->get_location_currency( $selected_location );
		$line_items        = array();
		foreach ( $submission_data['line_items'] as $line_item ) {
			// Filter empty line items and add default name for undefined line items.
			if ( empty( $line_item['name'] ) && empty( $line_item['unit_price'] ) ) {
				continue;
			} elseif ( empty( $line_item['name'] ) && ! empty( $line_item['unit_price'] ) ) {
				$line_item['name'] = __( 'Order item', 'gravityformssquare' );
			}
			$line_items[] = array(
				'name'             => $line_item['name'],
				'note'             => $line_item['description'],
				'quantity'         => (string) $line_item['quantity'],
				'base_price_money' => array(
					'amount'   => $this->get_amount_export( $line_item['unit_price'], $currency ),
					'currency' => $currency,
				),
			);
		}

		if ( empty( $line_items ) ) {
			$this->log_debug( __METHOD__ . '(): Not creating order; line items invalid; ' . print_r( $submission_data['line_items'], true ) );

			return;
		}

		$order_data = array(
			'idempotency_key' => $this->api->generate_idempotency_key(),
			'order'           => array(
				'location_id' => $selected_location,
				'line_items'  => $line_items,
			),
		);

		if ( ! is_null( $customer_id ) && ! is_wp_error( $customer_id ) ) {
			$this->log_debug( __METHOD__ . sprintf( '(): Adding customer_id (%s) to order data.', $customer_id ) );
			$order_data['order']['customer_id'] = $customer_id;
		}

		if ( is_array( $submission_data['discounts'] ) ) {
			$order_data['order']['discounts'] = array();
			foreach ( $submission_data['discounts'] as $discount ) {
				$order_data['order']['discounts'][] = array(
					'type'         => 'FIXED_AMOUNT',
					'uid'          => uniqid(),
					'name'         => $discount['name'],
					'amount_money' => array(
						'amount'   => $this->get_amount_export( ( $discount['quantity'] * $discount['unit_price'] ) * - 1, $currency ),
						'currency' => $currency,
					),
				);
			}
		}

		$order_id = $this->api->create_order( $selected_location, $order_data );
		if ( ! is_wp_error( $order_id ) ) {
			$this->log_debug( __METHOD__ . sprintf( '(): Adding order_id (%s) to payment data.', $order_id ) );
			$payment_data['order_id'] = $order_id;
		} else {
			$this->log_error( __METHOD__ . '(): Could not create order; ' . $order_id->get_error_message() );
		}

	}

	/**
	 * Validates an amount is greater than the minimum amount a business location can charge.
	 *
	 * @since 1.0.0
	 *
	 * @param string    $location_id Business Location ID.
	 * @param int|float $amount amount to be validated.
	 *
	 * @return bool
	 */
	public function validate_location_amount( $location_id, $amount ) {
		$country = $this->api->get_location_country( $location_id );

		if ( ( $country === 'US' || $country === 'CA' ) && $amount < 1 ) {
			return false;
		}

		if ( ( $country === 'JP' || $country === 'UK' || $country === 'AU' ) && $amount < 100 ) {
			return false;
		}

		return true;
	}

	/**
	 * Complete the Square payment which was created during validation.
	 *
	 * @since  1.0.0
	 *
	 * @param array $auth Contains the result of the authorize() function.
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array $payment Contains payment details. If failed, shows failure message.
	 */
	public function capture( $auth, $feed, $submission_data, $form, $entry ) {
		$location_id = $this->get_selected_location_id();

		if ( ! empty( $auth['order_id'] ) ) {
			$reference = 'Gravity Forms Entry #' . $entry['id'];
			$this->api->update_order_reference_id( $location_id, $auth['order_id'], $reference );
		}

		// Update entry mode, location and account ( for entry details square dashboard link ).
		gform_update_meta( $entry['id'], 'square_mode', $this->get_mode(), $form['id'] );
		gform_update_meta( $entry['id'], 'square_location', $location_id, $form['id'] );
		gform_update_meta( $entry['id'], 'square_merchant_id', $this->api->get_merchant_id(), $form['id'] );
		gform_update_meta( $entry['id'], 'square_merchant_name', $this->api->get_merchant_name(), $form['id'] );

		$capture_method = $this->get_capture_method( $feed, $submission_data, $form, $entry );

		if ( $capture_method === 'manual' ) {
			return array();
		}

		// Capture the charge.
		$payment_completed = $this->api->complete_payment( $auth['transaction_id'] );
		if ( is_wp_error( $payment_completed ) ) {
			// Log that charge could not be captured.
			$this->log_error( __METHOD__ . '(): Unable to capture charge; ' . $payment_completed->get_error_message() );

			// Prepare failed payment details.
			return array(
				'is_success'    => false,
				'error_message' => $payment_completed->get_error_message(),
			);
		}

		// Save receipt URL, so it can be used as a merge tag later.
		gform_update_meta( $entry['id'], 'square_receipt_url', rgar( $payment_completed, 'receipt_url' ), $form['id'] );

		// Prepare successful payment details.
		$payment = array(
			'is_success'     => true,
			'transaction_id' => rgar( $payment_completed, 'id' ),
			'amount'         => $this->get_amount_import( rgars( $payment_completed, 'amount_money/amount' ), $entry['currency'] ),
			'payment_method' => sanitize_text_field( rgpost( 'square_credit_card_type' ) ),
		);

		// Add Account name to payment note.
		$amount_formatted = GFCommon::to_money( $payment['amount'], $entry['currency'] );
		$payment['note']  = sprintf( esc_html__( 'Payment has been completed. Amount: %1$s. Transaction Id: %2$s. Square Account : %3$s. Business Location: %4$s', 'gravityformssquare' ), $amount_formatted, $payment['transaction_id'], $this->api->get_merchant_name(), $this->get_selected_location_name() );

		// Trigger delayed feeds for other addons like user registration.
		if ( method_exists( $this, 'trigger_payment_delayed_feeds' ) ) {
			$this->trigger_payment_delayed_feeds( $auth['transaction_id'], $feed, $entry, $form );
		}

		return $payment;
	}

	/**
	 * Get capture method (complete the payment or not) for the payment API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return string
	 */
	public function get_capture_method( $feed, $submission_data, $form, $entry ) {
		$feed_enabled_auth_only = rgars( $feed, 'meta/authorizeOnly' ) === '1';

		/**
		 * Allow authorization only transactions by preventing the capture request from being made after the entry has been saved.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $result Defaults to false, return true to prevent the payment from being captured.
		 * @param array $feed The feed object currently being processed.
		 * @param array $submission_data The customer and transaction data.
		 * @param array $form The form object currently being processed.
		 * @param array $entry The entry object currently being processed.
		 */
		$authorization_only = apply_filters( 'gform_square_authorization_only', $feed_enabled_auth_only, $feed, $submission_data, $form, $entry );

		if ( $authorization_only ) {
			$this->log_debug( __METHOD__ . '(): The gform_square_authorization_only filter was used to prevent capture.' );

			return 'manual';
		}

		return 'automatic';
	}

	/**
	 * Create a Square Subscription
	 *
	 * This method is executed during the form validation process and allows the form submission process to fail with a
	 * validation error if there is anything wrong when creating the subscription.
	 *
	 * @since 1.3
	 *
	 * @param array $feed            Current configured payment feed.
	 * @param array $submission_data Contains form field data submitted by the user as well as payment information
	 *                               (i.e. payment amount, setup fee, line items, etc...).
	 * @param array $form            Current form array containing all form settings.
	 * @param array $entry           Current entry array containing entry information (i.e data submitted by users).
	 *                               NOTE: the entry hasn't been saved to the database at this point, so this $entry
	 *                               object does not have the 'ID' property and is only a memory representation of the entry.
	 *
	 * @return array {
	 *     Return an $subscription array in the following format:
	 *
	 *     @type bool   $is_success      If the subscription is successful.
	 *     @type string $error_message   The error message, if applicable.
	 *     @type string $subscription_id The subscription ID.
	 *     @type int    $amount          The subscription amount.
	 *     @type array  $captured_payment {
	 *         If payment is captured, an additional array is created.
	 *
	 *         @type bool   $is_success     If the payment capture is successful.
	 *         @type string $error_message  The error message, if any.
	 *         @type string $transaction_id The transaction ID of the captured payment.
	 *         @type int    $amount         The amount of the captured payment, if successful.
	 *     }
	 *
	 * To implement an initial/setup fee for gateways that don't support setup fees as part of subscriptions, manually
	 * capture the funds for the setup fee as a separate transaction and send that payment information in the
	 * following 'captured_payment' array:
	 *
	 * 'captured_payment' => [
	 *     'name'           => 'Setup Fee',
	 *     'is_success'     => true|false,
	 *     'error_message'  => 'error message',
	 *     'transaction_id' => 'xxx',
	 *     'amount'         => 20
	 * ]
	 */
	public function subscribe( $feed, $submission_data, $form, $entry ) {

		$subscription = $this->get_subscriptions_handler()->initialize_subscription( $form, $feed, $submission_data, $entry );

		if ( ! $subscription instanceof Subscription ) {
			return $this->get_subscriptions_handler()->handle_error( $subscription );
		}

		return array(
			'is_success'      => true,
			'subscription_id' => $subscription->get_id(),
			'amount'          => $subscription->get_amount(),
		);

	}

	/**
	 * Create an instance of the Subscriptions_Handler class to process subscriptions-related requests.
	 *
	 * @since 1.3
	 *
	 * @return Square_Subscriptions_Handler
	 */
	public function initialize_subscriptions_handler() {
		if ( $this->subscriptions_handler instanceof Square_Subscriptions_Handler ) {
			return $this->subscriptions_handler;
		}

		if ( ! $this->api instanceof GF_Square_API ) {
			$this->initialize_api();
		}

		require_once gf_square()->get_base_path() . '/includes/class-square-subscriptions-handler.php';

		$this->subscriptions_handler = new Square_Subscriptions_Handler( $this->api, $this );

		return $this->subscriptions_handler;
	}

	/**
	 * Gets subscriptions handler instance if already initialize, otherwise, initialize it.
	 *
	 * @since 1.3
	 *
	 * @return Square_Subscriptions_Handler
	 */
	public function get_subscriptions_handler() {

		if ( $this->subscriptions_handler instanceof Square_Subscriptions_Handler ) {
			return $this->subscriptions_handler;
		}

		return $this->initialize_subscriptions_handler();
	}

	/**
	 * Get square payment object associated with an entry.
	 *
	 * @param array $entry the entry being processed.
	 *
	 * @return bool|array
	 */
	public function get_entry_square_payment( $entry ) {
		// Load entry custom auth data.
		$entry_mode      = gform_get_meta( $entry['id'], 'square_mode' );
		$entry_auth_data = $this->get_auth_data( $entry_mode );
		if ( is_null( $entry_auth_data ) || ! $this->initialize_api( $entry_auth_data, $entry_mode ) ) {
			return false;
		}

		$payment = $this->api->get_payment( $entry['transaction_id'] );
		if ( is_wp_error( $payment ) ) {
			return false;
		}

		return $payment;
	}

	/**
	 * Handle failed capture event.
	 *
	 * @since  1.2.1
	 *
	 * @param array $entry The entry details.
	 * @param array $action The action.
	 *
	 * @return bool
	 */
	public function fail_capture( $entry, $action ) {
		$this->log_debug( __METHOD__ . '(): Processing failed captured request.' );

		$action = $this->maybe_add_action_amount_formatted( $action, $entry['currency'] );

		if ( empty( $action['note'] ) ) {
			$action['note'] = sprintf(
			/* translators: Amount of transaction. */
				esc_html__( 'Authorized payment has failed capture request. Amount: %s.', 'gravityformssquare' ),
				$action['amount_formatted']
			);
		}

		$this->add_note( $entry['id'], $action['note'] );
		$this->post_payment_action( $entry, $action );

		return true;
	}

	/**
	 * Initialize admin hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_admin() {
		parent::init_admin();
		add_action( 'gform_payment_details', array( $this, 'add_square_payment_details' ), 10, 2 );
		add_action( 'gform_payment_details', array( $this, 'maybe_add_payment_details_button' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'maybe_update_auth_tokens' ) );
		add_action( 'admin_notices', array( $this, 'maybe_display_authentication_notice' ) );
	}

	/**
	 * Generates the callback action for entry payment status update.
	 *
	 * @since 1.0.0
	 *
	 * @param array $entry   The entry object currently being processed.
	 * @param array $payment Square payment object.
	 *
	 * @return void|array callback action.
	 */
	public function get_entry_status_action( $entry, $payment ) {
		$sq_status    = rgar( $payment, 'status' );
		$entry_status = $entry['payment_status'];
		$action       = array(
			'type'           => null,
			'transaction_id' => rgar( $payment, 'id' ),
			'entry_id'       => $entry['id'],
		);

		if ( $entry_status == 'Authorized' ) {

			if ( $sq_status == 'COMPLETED' ) {
				$action['type'] = 'complete_payment';
			} elseif ( $sq_status == 'CANCELED' ) {
				$action['type'] = 'void_authorization';
			} elseif ( $sq_status == 'FAILED' ) {
				$action['type'] = 'fail_payment';
			}

			return $action;

		} elseif ( $entry_status == 'Paid' ) {
			// If paid payment, check refund status.
			$pending_refund = false;
			$failed_refund  = false;

			if ( empty( $payment['refund_ids'] ) || ! is_array( $payment['refund_ids'] ) ) {
				return $action;
			}

			$refunds = array();
			foreach ( $payment['refund_ids'] as $refund_id ) {
				$refund = $this->api->get_refund( $refund_id );
				if ( is_wp_error( $refund ) ) {
					continue;
				}
				$status = rgar( $refund, 'status' );
				if ( $status == 'PENDING' ) {
					$pending_refund = true;
				} elseif ( $status == 'FAILED' ) {
					$failed_refund = true;
				}
				$refunds[ $refund_id ] = array(
					'id'     => $refund_id,
					'status' => $status,
					'amount' => rgars( $refund, 'amount_money/amount' ),
				);
			}

			// Update entry refunds.
			if ( ! empty( $refunds ) ) {
				gform_update_meta( $entry['id'], 'square_refunds', $refunds, $entry['form_id'] );
			}

			if ( $pending_refund ) {
				gform_update_meta( $entry['id'], 'refund_status', 'pending', $entry['form_id'] );
				// $action['type'] = 'pending_refund';
			} elseif ( $failed_refund ) {
				gform_update_meta( $entry['id'], 'refund_status', 'failed', $entry['form_id'] );
				// $action['type'] = 'failed_refund';
			} else {
				// If no pending refunds found, check partial and completed refunds.
				$refunded_money = rgars( $payment, 'refunded_money/amount', 0 );
				$payment_amount = $this->get_amount_export( $entry['payment_amount'], $entry['currency'] );
				if ( $refunded_money >= $payment_amount ) {
					$action['type']   = 'refund_payment';
					$action['amount'] = $entry['payment_amount'];
					gform_update_meta( $entry['id'], 'refund_status', 'completed', $entry['form_id'] );
				} elseif ( ! empty( $refunded_money ) && $refunded_money < $payment_amount ) {
					// Mayeb we need custom event for partial refund later.
					$action['type']   = 'refund_payment';
					$action['amount'] = $this->get_amount_import( $refunded_money, $entry['currency'] );
					gform_update_meta( $entry['id'], 'refund_status', 'completed', $entry['form_id'] );
				}
			}
		}

		return $action;
	}

	/**
	 * Add Square dashboard transaction payment link.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $form_id The current form ID.
	 * @param array $entry The current entry being processed.
	 */
	public function add_square_payment_details( $form_id, $entry ) {

		// Check if this is a square payment entry.
		if ( ! $this->is_square_entry( $entry['id'] ) ) {
			return;
		}

		$is_single_payment       = $entry['transaction_type'] === self::PAYMENT_TRANSACTION_TYPE;
		$is_subscription_payment = $entry['transaction_type'] === self::SUBSCRIPTION_TRANSACTION_TYPE;

		if ( $is_single_payment ) {
			$this->display_payment_details_link( $entry );

			// Display warning if payment is authorized only and not cancelled yet.
			$now        = time();
			$entry_date = strtotime( $entry['date_created'] );
			$datediff   = $now - $entry_date;
			$days       = round( $datediff / DAY_IN_SECONDS );
			if ( $entry['payment_status'] == 'Authorized' && $days < 6 ) {
				echo '<p class="detail-note-content gforms_note_warning">' . esc_html__( 'Authorized payments must be captured within six days otherwise they will be canceled.', 'gravityformssquare' ) . '</p>';
			}
		} elseif ( $is_subscription_payment ) {
			// Show customer info.
		}
	}

	/**
	 * Displays a link to the Square dashboard payment details page for completed payments.
	 *
	 * @since 1.3
	 *
	 * @param array $entry The entry currently being viewed.
	 */
	private function display_payment_details_link( $entry ) {
		if ( $entry['payment_status'] === 'Authorized' ) {
			return;
		}

		$entry_mode     = gform_get_meta( $entry['id'], 'square_mode' );
		$dashboard_host = $entry_mode === 'sandbox' ? 'https://squareupsandbox.com' : 'https://squareup.com';

		printf(
			'<p><a target="_blank" href="%s" class="square_dashboard_link">%s</a></p>',
			esc_attr( $dashboard_host . '/dashboard/sales/transactions/' . $entry['transaction_id'] ),
			esc_html__( 'View payment on Square dashboard.', 'gravityformssquare' )
		);

		$merchant_name = gform_get_meta( $entry['id'], 'square_merchant_name' );
		if ( ! empty( $merchant_name ) ) {
			echo '<p>' . esc_html__( 'You have to be logged in to the following square account for this link to work: ', 'gravityformssquare' ) . '<strong>' . esc_html( $merchant_name ) . '</strong></p>';
		}
	}

	/**
	 * Adds a capture or refund button to the payment details box if the payment status allows it.
	 *
	 * @since 1.3
	 *
	 * @param int   $form_id The ID of the form the entry belongs to.
	 * @param array $entry   The current entry array.
	 */
	public function maybe_add_payment_details_button( $form_id, $entry ) {
		if ( ! $this->can_display_payment_details_button( $entry, array( 'Paid', 'Authorized', 'Active' ) ) ) {
			return;
		}

		switch ( $entry['payment_status'] ) {
			case 'Authorized':
				$button = array(
					'label' => __( 'Capture Payment', 'gravityformssquare' ),
					'data'  => array(
						'api_action' => 'capture',
					),
				);
				break;
			case 'Paid':
				$status = gform_get_meta( $entry['id'], 'refund_status' );

				if ( $status === 'pending' ) {
					$button = array(
						'label'    => __( 'Refund Pending', 'gravityformssquare' ),
						'disabled' => true,
						'data'     => array(
							'api_action' => 'refund',
						),
					);
				} elseif ( $status !== 'completed' && $status !== 'failed' ) {
					$button = array(
						'label' => __( 'Refund Payment', 'gravityformssquare' ),
						'data'  => array(
							'api_action' => 'refund',
							'currency'   => $entry['currency'],
							'amount'     => $entry['payment_amount'],
						),
					);
				}
				break;
			case 'Active':
				if ( $entry['payment_status'] === 'Active' ) {
					$button = array(
						'label' => __( 'Cancel Subscription', 'gravityformssquare' ),
						'data'  => array(
							'api_action' => 'cancel_subscription',
							'currency'   => $entry['currency'],
							'amount'     => $entry['payment_amount'],
						),
					);
				}
				break;
		}

		if ( ! isset( $button ) ) {
			return;
		}

		$button['data'] = array_merge(
			$button['data'],
			array(
				'action'         => 'gfsquare_payment_details_action',
				'nonce'          => wp_create_nonce( 'gfsquare_payment_details_nonce' ),
				'entry_id'       => absint( $entry['id'] ),
				'transaction_id' => $entry['transaction_id'],
			)
		);

		$spinner_url = GFCommon::get_base_url() . '/images/spinner.' . ( $this->is_gravityforms_supported( '2.5-beta' ) ? 'svg' : 'gif' );
		$disabled    = isset( $button['disabled'] ) && $button['disabled'] ? 'disabled="disabled"' : '';
		?>
		<div id="gfsquare_payment_details_button_container">
			<input id="gfsquare_<?php echo esc_attr( $button['data']['api_action'] ); ?>" type="button" name="<?php echo esc_attr( $button['data']['api_action'] ); ?>"
					value="<?php echo esc_attr( $button['label'] ); ?>" class="button gfsquare-payment-action"
					data-entry="<?php echo esc_attr( wp_json_encode( $button['data'] ) ); ?>"
					<?php echo esc_attr( $disabled ); ?>
			/>
			<img src="<?php echo esc_url( $spinner_url ); ?>" id="gfsquare_ajax_spinner" style="display: none;"/>
		</div>
		<?php
	}

	/**
	 * Checks if payment details button should be displayed or nott.
	 *
	 * @since 1.3
	 *
	 * @param array $entry            Current entry being processed.
	 * @param array $allowed_statuses Payment statuses that can have a button.
	 *
	 * @return bool
	 */
	private function can_display_payment_details_button( $entry, $allowed_statuses ) {
		return (
			rgget( 'page' ) === 'gf_entries'
			&& $this->is_payment_gateway( $entry['id'] )
			&& in_array( $entry['payment_status'], $allowed_statuses )
		);
	}

	/**
	 * Syncs payments refund status with Square.
	 *
	 * @since 1.0.0
	 *
	 * @param string $last_update last time we checked for refund updates.
	 *
	 * @return void
	 */
	public function sync_refunds( $last_update = null ) {
		// Get all authenticated modes.
		$modes = array( 'live', 'sandbox' );
		foreach ( $modes as $mode ) {
			// Check if mode auth data is stored.
			$mode_auth_data = $this->get_auth_data( $mode );
			if ( is_null( $mode_auth_data ) ) {
				continue;
			}

			if ( ! $this->initialize_api( $mode_auth_data, $mode, true ) ) {
				$this->log_error( __METHOD__ . '(): can\'t authenticate ' . $mode . ' mode to update refunds' );
				continue;
			}

			$refunds = $this->api->get_completed_refunds( $last_update );

			if ( is_wp_error( $refunds ) ) {
				$this->log_error( __METHOD__ . '(): unable to get refunds; ' . $refunds->get_error_message() );
				continue;
			}

			foreach ( $refunds as $refund ) {
				$entry_id = $this->get_entry_by_transaction_id( rgar( $refund, 'payment_id' ) );
				$entry    = GFAPI::get_entry( $entry_id );

				// Make sure entry exist and status can be changed to refunded.
				if ( ! is_array( $entry ) || empty( $entry['payment_status'] ) || ! in_array( $entry['payment_status'], array( 'Paid', 'Authorized' ) ) ) {
					continue;
				}
				$refund_amount = $this->get_amount_import( rgars( $refund, 'amount_money/amount' ), $entry['currency'] );
				$action        = array(
					'transaction_id' => $refund['payment_id'],
					'entry_id'       => $entry['id'],
					'type'           => 'refund_payment',
					'amount'         => $refund_amount,
				);

				$this->refund_payment( $entry, $action );
				gform_update_meta( $entry['id'], 'refund_status', 'completed', $entry['form_id'] );
			}
		}
	}

	// --------------------------------------------------------------------------------------------------------- //
	// -------------------------------------------- Helpers ---------------------------------------------------- //
	// --------------------------------------------------------------------------------------------------------- //

	/**
	 * Returns the encryption key
	 *
	 * @since 1.0.0
	 *
	 * @return string encryption key.
	 */
	public function get_encryption_key() {
		// Check if key exists in config file.
		if ( defined( 'GRAVITYFORMS_SQUARE_ENCRYPTION_KEY' ) && GRAVITYFORMS_SQUARE_ENCRYPTION_KEY ) {
			return GRAVITYFORMS_SQUARE_ENCRYPTION_KEY;
		}

		// Check if key exists in Database.
		$key = get_option( 'gravityformssquare_key' );

		if ( empty( $key ) ) {
			// Key hasn't been generated yet, generate it and save it.
			$key = wp_generate_password( 64, true, true );
			update_option( 'gravityformssquare_key', $key );
		}

		return $key;
	}

	/**
	 * Checks if we should use sandbox environment.
	 *
	 * @since  1.0.0
	 *
	 * @return bool
	 */
	public function is_sandbox() {
		return $this->get_mode() === 'sandbox';
	}

	/**
	 * Return the plugin's icon for the plugin/form settings menu.
	 *
	 * @since 1.3
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return file_get_contents( $this->get_base_path() . '/images/menu-icon.svg' );
	}

	/**
	 * Get API mode.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_mode() {
		// If this request is updating the settings, get the posted mode value because it has not been saved yet.
		if ( $this->is_save_postback() ) {
			// check if we should use legacy input prefix.
			if ( $this->is_gravityforms_supported( '2.5-beta' ) ) {
				$input_name = '_gform_setting_mode';
			} else {
				$input_name = '_gaddon_setting_mode';
			}

			$mode = sanitize_text_field( rgpost( $input_name ) );
		}

		if ( empty( $mode ) ) {
			$mode = $this->get_plugin_setting( 'mode' );
		}

		return empty( $mode ) ? 'live' : $mode;
	}

	/**
	 * Get data sync setting.
	 *
	 * @since 1.3
	 *
	 * @return bool
	 */
	public function is_sync_enabled() {
		/**
		 * Allows data sync to be disabled. Default is enabled.
		 *
		 * @since 1.3
		 *
		 * @param int $enabled If data sync should occur.
		 */
		return (bool) apply_filters( 'gform_square_data_sync_enabled', true );
	}

	/**
	 * Gets the Gravity Forms Square Application ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string the application id.
	 */
	public function get_application_id() {
		$mode = $this->get_mode();
		if ( $this->get_plugin_setting( 'custom_app_' . $mode ) === '1' ) {
			return $this->get_plugin_setting( 'custom_app_id_' . $mode );
		}
		if ( $this->is_sandbox() ) {
			return defined( 'SQUARE_SANDBOX_APP_ID' ) ? SQUARE_SANDBOX_APP_ID : 'sandbox-sq0idb-pNhEAzS58zAaqOrijuSLxQ';
		}

		return defined( 'SQUARE_APP_ID' ) ? SQUARE_APP_ID : 'sq0idp-6IFu0hb9rVdgZpUBxDF1Ug';
	}

	/**
	 * Gets the selected Square business location ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $custom_mode specify a different mode than the current default mode.
	 * @return string|null Returns the location id or null if no location selected.
	 */
	public function get_selected_location_id( $custom_mode = null ) {
		$mode = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		return $this->get_plugin_setting( 'location_' . $mode );
	}

	/**
	 * Gets the selected Square business location Name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $custom_mode specify a different mode than the current default mode.
	 * @return string|null Returns the location name or null if no location selected.
	 */
	public function get_selected_location_name( $custom_mode = null ) {
		$location_id = $this->get_selected_location_id( $custom_mode );
		return $this->api->get_location_name( $location_id );
	}

	/**
	 * Checks if a Square business location was selected.
	 *
	 * @return bool
	 */
	public function square_location_selected() {
		$location_id = $this->get_selected_location_id();

		if ( empty( $location_id ) ) {
			return false;
		}

		$active_locations = $this->api->get_active_locations();
		foreach ( $active_locations as $location ) {
			if ( $location_id === $location['value'] ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Gets the selected business location currency.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|string the currency of selected location or false if no location selected.
	 */
	public function get_selected_location_currency() {
		$location_id = $this->get_selected_location_id();

		if ( empty( $location_id ) || is_null( $this->api ) ) {
			return false;
		}

		return $this->api->get_location_currency( $location_id );
	}

	/**
	 * Checks if stored square business location's currency matches GF currency.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function square_currency_matches_gf() {
		$selected_location = $this->get_selected_location_id();

		if ( empty( $selected_location ) || is_null( $this->api ) ) {
			return false;
		}

		return strtoupper( $this->api->get_location_currency( $selected_location ) ) === strtoupper( GFCommon::get_currency() );
	}

	/**
	 * Get Gravity API URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path Path.
	 *
	 * @return string
	 */
	public function get_gravity_api_url( $path = '' ) {
		return ( defined( 'GRAVITY_API_URL' ) ? GRAVITY_API_URL : 'https://gravityapi.com/wp-json/gravityapi/v1' ) . $path;
	}

	/**
	 * Get Square Auth URL for custom app.
	 *
	 * @since 1.0.0
	 *
	 * @param string $app_id custom app id.
	 * @param string $app_secret custom app secret.
	 *
	 * @return string
	 */
	public function get_square_auth_url( $app_id, $app_secret ) {
		// Get base OAuth URL.
		$auth_url = $this->get_square_host_url() . '/oauth2/authorize';
		$state    = wp_create_nonce( 'gf_square_auth' );
		// Session should be true if in sandbox mode.
		$session = $this->is_sandbox() ? 'true' : 'false';
		// Prepare OAuth URL parameters.
		$auth_params = array(
			'client_id' => $app_id,
			'scope'     => 'MERCHANT_PROFILE_READ+PAYMENTS_READ+PAYMENTS_WRITE+ORDERS_READ+ORDERS_WRITE+CUSTOMERS_READ+CUSTOMERS_WRITE+SUBSCRIPTIONS_READ+SUBSCRIPTIONS_WRITE+ITEMS_READ+ITEMS_WRITE+INVOICES_READ+INVOICES_WRITE',
			'state'     => $state,
			'session'   => $session,
		);

		// Add parameters to OAuth url.
		$auth_url = add_query_arg( $auth_params, $auth_url );

		return $auth_url;
	}

	/**
	 * Checks if an entry is a square payment entry.
	 *
	 * @since 1.0.0
	 *
	 * @param int $entry_id current entry being processed.
	 *
	 * @return bool
	 */
	public function is_square_entry( $entry_id ) {
		// Check if this is a square payment entry.
		$gateway = gform_get_meta( $entry_id, 'payment_gateway' );
		return $gateway === $this->_slug;
	}

	/**
	 * Retrieves access tokens from gravityapi.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code Authorization code.
	 * @param string $mode live or sandbox.
	 *
	 * @return bool|array
	 */
	public function get_tokens( $code, $mode ) {
		// Get Tokens.
		$get_token_url = $this->get_gravity_api_url( '/auth/square/token' );
		$args          = array(
			'body' => array(
				'code' => $code,
				'mode' => $mode,
			),
		);

		$response = wp_remote_post( $get_token_url, $args );

		// If there was an error, log and return false.
		if ( is_wp_error( $response ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get token; ' . $response->get_error_message() );
			return false;
		}

		// Get response body.
		$response_body = wp_remote_retrieve_body( $response );

		$response_body = json_decode( $response_body, true );
		if ( ! $response_body['success'] ) {
			return false;
		}

		return $response_body['data'];
	}

	/**
	 * Get tokens for custom app.
	 *
	 * @param string $data refresh token or auth code.
	 * @param string $type grant type.
	 * @param null   $custom_mode if we should use a specific mode.
	 *
	 * @return bool|mixed|string
	 */
	public function get_custom_app_tokens( $data, $type = 'authorization_code', $custom_mode = null ) {

		// Get base OAuth URL.
		$auth_url = $this->get_square_host_url() . '/oauth2/token';

		// Prepare OAuth URL parameters.
		$mode        = is_null( $custom_mode ) ? $this->get_mode() : $custom_mode;
		$auth_params = array(
			'client_id'     => $this->get_plugin_setting( 'custom_app_id_' . $mode ),
			'client_secret' => $this->get_plugin_setting( 'custom_app_secret_' . $mode ),
			'grant_type'    => $type,
		);

		if ( 'authorization_code' == $type ) {
			$auth_params['code'] = $data;
		} else {
			$auth_params['refresh_token'] = $data;
		}

		$args     = array( 'body' => $auth_params );
		$response = wp_remote_post( $auth_url, $this->add_square_headers( $args ) );

		// If there was an error, log and return false.
		if ( is_wp_error( $response ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get token; ' . $response->get_error_message() );
			return false;
		}

		// Get response body.
		$response_body = wp_remote_retrieve_body( $response );
		$response_body = json_decode( $response_body, true );

		return $response_body;

	}

	/**
	 * Returns Square host url after checking if sandbox mode is on.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_square_host_url() {
		if ( $this->is_sandbox() ) {
			return 'https://connect.squareupsandbox.com';
		}

		return 'https://connect.squareup.com';
	}

	/**
	 * Checks if we are ready to make square API calls.
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function square_api_ready() {
		return $this->initialize_api() && $this->square_currency_matches_gf();
	}

	/**
	 * Adds Square specific headers to API requests that are made without the Square API library.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Request args.
	 *
	 * @return array
	 */
	public function add_square_headers( &$args ) {
		if ( empty( $args['headers'] ) ) {
			$args['headers'] = array();
		}

		$args['headers']['Square-Version'] = '2019-11-20';

		return $args;
	}
}
