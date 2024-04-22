<?php

namespace Gravity_Forms\Gravity_Forms_Square;

defined( 'ABSPATH' ) || die();

use GF_Square;
use GFAddOn;
use GFPaymentAddOn;
use Gravity_Forms\Gravity_Forms_Square\Subscriptions\Subscription;
use Gravity_Forms\Gravity_Forms_Square\Subscriptions\Plan;
use WP_Error;
use GF_Square_API;
use GFAPI;

/**
 * Gravity Forms Square Subscriptions Handler Library.
 *
 * This class acts as a wrapper for all things for creating Square Checkout Subscriptions over the API.
 *
 * @see https://developer.squareup.com/docs/subscriptions/overview
 *
 * @since     1.3
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2020, Rocketgenius
 */
class Square_Subscriptions_Handler {
	/**
	 * Instance of the Square API object.
	 *
	 * @since 1.3
	 *
	 * @var GF_Square_API
	 */
	protected $api;

	/**
	 * Instance of a GFPaymentAddOn object.
	 *
	 * @since 1.3
	 *
	 * @var GF_Square
	 */
	protected $addon;

	/**
	 * Load required classes and initialize Product, Plan, and Subscription CRUD models.
	 *
	 * Could probably use some sort of autoloader here.
	 *
	 * @since 1.3
	 *
	 * @param GF_Square_API $api   Instance of Square API.
	 * @param GF_Square     $addon GF_Square add-on instance.
	 */
	public function __construct( $api, $addon ) {
		$this->api   = $api;
		$this->addon = $addon;

		if ( ! class_exists( 'Gravity_Forms\Gravity_Forms_Square\Subscriptions\Subscription' ) ) {
			$this->load_class_dependencies();
		}
	}

	/**
	 * Determine whether a feed is a subscriptions feed.
	 *
	 * @since 1.3
	 *
	 * @param array $feed The feed data.
	 *
	 * @return bool
	 */
	public function is_subscription_feed( array $feed ) {
		$is_feed_edit_page = $this->addon->is_gravityforms_supported( '2.5-beta' ) ? $this->addon->is_feed_edit_page() : $this->addon->is_detail_page();
		if ( $is_feed_edit_page && 'POST' === rgar( $_SERVER, 'REQUEST_METHOD' ) ) {
			$prefix = $this->addon->is_gravityforms_supported( '2.5-beta' ) ? '_gform' : '_gaddon';

			return rgpost( "{$prefix}_setting_transactionType" ) === 'subscription';
		}

		return rgars( $feed, 'meta/transactionType' ) === 'subscription';
	}

	/**
	 * Initializes a subscription.
	 *
	 * @since 1.3
	 *
	 * @param array $form            The form data.
	 * @param array $feed            The feed data.
	 * @param array $submission_data The form submission data.
	 * @param array $entry           The form entry data.
	 *
	 * @return Subscription|WP_Error
	 */
	public function initialize_subscription( array $form, array $feed, array $submission_data = array(), array $entry = array() ) {

		return $this->create_subscription( $form, $feed, $submission_data, $entry );
	}

	/**
	 * Create a subscription from the form submission.
	 *
	 * @since 1.3
	 *
	 * @param array $form            The form data.
	 * @param array $feed            The feed data.
	 * @param array $submission_data The form submission data.
	 * @param array $entry           The form entry data.
	 *
	 * @return Subscription|WP_Error
	 */
	public function create_subscription( array $form, array $feed, array $submission_data, array $entry ) {

		$plan = $this->get_plan_for_submission( $form, $feed, $submission_data, $entry );

		if ( ! $plan instanceof Plan ) {
			return $plan;
		}

		// Gets Square customer based on email address.
		$square_customer = $this->get_customer( $form, $feed, $entry );

		if ( is_wp_error( $square_customer ) ) {
			return $square_customer;
		}

		// Gets billing information from the form submission.
		$form_submission_customer_data = $this->get_customer_data( $form, $feed, $entry );

		// Updates Square customer record if appropriate.
		if ( $this->should_update_customer( $square_customer, $form_submission_customer_data ) ) {

			// Prepares customer array to be sent to Square.
			$customer_data = $this->prepare_for_update( $form_submission_customer_data );

			// Updates customer data (email, name and address) based on submitted data.
			$result = $this->api->update_customer( $square_customer['id'], $customer_data );

			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}

		$card_id = $this->get_card_id( $form, $feed, $submission_data, $entry, $square_customer['id'] );

		if ( is_wp_error( $card_id ) ) {
			return $card_id;
		}

		$subscription_response = $this->api->create_subscription( $this->addon->get_selected_location_id(), $plan->id, $square_customer['id'], $card_id, array() );

		if ( is_wp_error( $subscription_response ) ) {
			return $subscription_response;
		}

		return ( new Subscription( $plan ) )->load_from_api_response( $subscription_response );
	}

	/**
	 * Retrieve entries with transaction_type 2
	 *
	 * @since 1.3
	 *
	 * @return array
	 */
	public function get_subscription_entries() {
		$forms = array();

		foreach ( $this->addon->get_feeds() as $feed ) {
			if ( ! $this->is_subscription_feed( $feed ) ) {
				continue;
			}

			$forms[] = $feed['form_id'];
		}

		if ( empty( $forms ) ) {
			return array();
		}

		$entry_search = array(
			'payment_status' => 'Active',
			'field_filter'   => array(
				array(
					'key'   => 'transaction_type',
					'value' => GF_Square::SUBSCRIPTION_TRANSACTION_TYPE,
				),
				array(
					'key'      => 'transaction_id',
					'operator' => 'isnot',
					'value'    => '',
				),
			),
		);

		$entries = GFAPI::get_entries( $forms, $entry_search );

		if ( ! is_array( $entries ) ) {
			return array();
		}

		return $entries;
	}

	/**
	 * Get Subscriptions from Square API.
	 *
	 * @since 1.3
	 *
	 * @return array
	 */
	public function get_subscriptions() {
		if ( ! $this->api ) {
			return array();
		}

		$entries = $this->get_subscription_entries();

		if ( empty( $entries ) ) {
			return array();
		}

		$subscriptions = array();

		foreach ( $entries as $entry ) {
			$subscription = $this->api->get_subscription( $entry['transaction_id'] );
			if ( ! is_array( $subscription ) ) {
				continue;
			}

			// Add Entry data to subscription array.
			$subscription['gf_entry'] = $entry;

			$subscriptions[] = $subscription;
		}

		return $subscriptions;
	}

	/**
	 * Get unpaid invoices from array of invoices.
	 *
	 * @since 1.3
	 *
	 * @param array $invoice_ids Array of invoice IDs.
	 *
	 * @return array
	 */
	public function get_unpaid_invoices( array $invoice_ids ) {
		$unpaid = array();

		foreach ( $invoice_ids as $invoice_id ) {
			$invoice = $this->api->get_invoice( $invoice_id );

			if ( 'PAID' === $invoice['status'] ) {
				continue;
			}

			$unpaid[] = $invoice;
		}

		return $unpaid;
	}

	/**
	 * Gets the subscription plan from square or creates a new one using submission and feed data.
	 *
	 * @since 1.3
	 *
	 * @param array $form            The form data.
	 * @param array $feed            The feed data.
	 * @param array $submission_data The form submission data.
	 * @param array $entry           The form entry data.
	 *
	 * @return Plan|WP_Error
	 */
	public function get_plan_for_submission( array $form, array $feed, array $submission_data, array $entry ) {

		$plan = new Plan();
		$plan->init_from_submission( $form, $feed, $submission_data, $entry );

		$legacy_search_params = array(
			'object_types' => array(
				'SUBSCRIPTION_PLAN',
			),
			'query'        => array(
				'exact_query' => array(
					'attribute_name'  => 'name',
					'attribute_value' => $plan->legacy_name,
				),
			),
		);

		$search_result = $this->api->search_catalog( $legacy_search_params );

		if ( is_wp_error( $search_result ) || ! isset( $search_result['objects'] ) || count( $search_result['objects'] ) <= 0 ) {
			$search_params = array(
				'object_types' => array(
					'SUBSCRIPTION_PLAN',
				),
				'query'        => array(
					'exact_query' => array(
						'attribute_name'  => 'name',
						'attribute_value' => $plan->name,
					),
				),
			);
			$search_result = $this->api->search_catalog( $search_params );
		}

		if ( is_wp_error( $search_result ) || ! isset( $search_result['objects'] ) || count( $search_result['objects'] ) <= 0 ) {
			$square_plan_response = $this->api->create_plan( $plan->get_api_create_request() );
			if ( is_wp_error( $square_plan_response ) ) {
				return $square_plan_response;
			}
		} else {
			$square_plan_response = $search_result['objects'][0];
		}

		return $plan->load_from_api_response( $square_plan_response );
	}

	/**
	 * Retrieves customer from square by looking up the provided email address, creates one if no customers with that email address exist.
	 *
	 * @since 1.3
	 *
	 * @param array $form
	 * @param array $feed
	 * @param array $submission_data
	 * @param array $entry
	 *
	 * @return String|WP_Error Customer ID or error.
	 */
	public function get_customer_id( array $form, array $feed, array $submission_data, array $entry ) {

		_deprecated_function( 'get_customer_id', '1.5.3', 'get_customer' );

		$customer_data = $this->get_customer_data( $form, $feed, $entry );
		$email     = rgar( $customer_data, 'email_address' );

		if ( empty( $email ) || ! is_email( $email ) ) {
			return new WP_Error( 'missing-email-address', __( 'Please provide a valid email address', 'gravityformssquare' ) );
		}

		$search_params = array(
			'query' => array(
				'filter' => array(
					'email_address' => array(
						'exact' => $email,
					),
				),
			),
		);
		$search_result = $this->api->search_customers( $search_params );

		if ( is_wp_error( $search_result ) || ! isset( $search_result['customers'] ) || count( $search_result['customers'] ) <= 0 ) {
			return $this->api->create_customer( $customer_data );
		}

		return rgars( $search_result, 'customers/0/id' );
	}


	/**
	 * Adds card on file for the provided customer and returns card ID.
	 *
	 * @since 1.3
	 *
	 * @param array  $form            GF Form array.
	 * @param array  $feed            GF Feed array.
	 * @param array  $submission_data GF Submission data.
	 * @param array  $entry           GF Entry array.
	 * @param string $customer_id     The customer ID.
	 *
	 * @return string|WP_Error
	 */
	public function get_card_id( array $form, array $feed, array $submission_data, array $entry, $customer_id ) {

		$square_field    = $this->addon->get_square_card_field( $form );
		$cardholder_name = $entry[ $square_field['id'] . '.3' ];

		$card = array(
			'card_nonce'      => sanitize_text_field( rgpost( 'square_nonce' ) ),
			'verification'    => sanitize_text_field( rgpost( 'square_verification' ) ),
			'cardholder_name' => $cardholder_name,
		);

		$response = $this->api->create_customer_card( $customer_id, $card );
		if ( is_wp_error( $response ) || ! isset( $response['id'] ) ) {
			return $response;
		}

		return $response['id'];
	}

	/**
	 * Cancels a subscription.
	 *
	 * @since 1.3
	 *
	 * @param array  $entry           The entry details.
	 * @param string $subscription_id The subscription id to be cancelled.
	 *
	 * @return array|WP_Error Cancelled subscription details or an error.
	 */
	public function cancel_subscription( $entry, $subscription_id ) {
		$response = $this->api->cancel_subscription( $subscription_id );
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$subscription = rgars( $response, 'subscription' );
		if ( empty( $subscription ) ) {
			return new WP_Error( 'missing-subscription-data', __( 'Unable to retrieve subscription', 'gravityformssquare' ) );
		}

		$feed = $this->addon->get_payment_feed( $entry );
		$this->addon->cancel_subscription( $entry, $feed );

		gform_update_meta( $entry['id'], 'square_subscription_canceled_at', $subscription['canceled_date'] );

		return $subscription;
	}


	/**
	 * Retrieves customer from square by looking up the provided email address, creates one if no customers with that email address exist.
	 *
	 * @since 1.5.3
	 *
	 * @param array $form Current form object.
	 * @param array $feed Current feed object.
	 * @param array $entry Current entry object.
	 *
	 * @return String|WP_Error Customer ID or error.
	 */
	private function get_customer( array $form, array $feed, array $entry ) {

		$customer_data = $this->get_customer_data( $form, $feed, $entry );
		$email     = rgar( $customer_data, 'email_address' );

		if ( empty( $email ) || ! is_email( $email ) ) {
			return new WP_Error( 'missing-email-address', __( 'Please provide a valid email address', 'gravityformssquare' ) );
		}

		$search_params = array(
			'query' => array(
				'filter' => array(
					'email_address' => array(
						'exact' => $email,
					),
				),
			),
		);
		$search_result = $this->api->search_customers( $search_params );

		if ( is_wp_error( $search_result ) || ! isset( $search_result['customers'] ) || count( $search_result['customers'] ) <= 0 ) {

			$customer_data = $this->prepare_for_update( $customer_data );

			// Square customer not found. Create one.
			$customer_id = $this->api->create_customer( $customer_data );
			if ( is_wp_error( $customer_id ) ) {
				return $customer_id;
			}
			$customer_data['id'] = $customer_id;
		} else {

			// Square customer found. Populating return array to contain information from Square customer.
			$square_customer = rgars( $search_result, 'customers/0' );
			foreach ( $customer_data as $key => $value ) {
				$customer_data[ $key ] = rgar( $square_customer, $key );
			}
			$customer_data['id'] = $square_customer['id'];
		}

		return $customer_data;
	}

	/**
	 * Determines if Square customer record needs to be updated given the billing information submitted.
	 *
	 * @since 1.5.3
	 *
	 * @param array $existing_customer Current Square customer.
	 * @param array $new_customer_data Customer information submitted from the form.
	 *
	 * @return boolean True if customer record should be updated. False otherwise.
	 */
	private function should_update_customer( $existing_customer, $new_customer_data ) {

		$new_customer_data = $this->prepare_for_update( $new_customer_data );

		$new_customer_has_name = isset( $new_customer_data['given_name'] );
		$name_changed = rgar( $new_customer_data, 'given_name' ) != rgar( $existing_customer, 'given_name' ) || rgar( $new_customer_data, 'family_name' ) != rgar( $existing_customer, 'family_name' );

		$new_customer_has_address = isset( $new_customer_data['address'] );
		$address_changed = rgar( $existing_customer, 'address' ) != rgars( $new_customer_data, 'address' );

		$should_update = ( $new_customer_has_name && $name_changed ) || ( $new_customer_has_address && $address_changed );
		return $should_update;
	}

	/**
	 * Prepare customer data to be sent to Square's update customer request.
	 *
	 * @since 1.5.3
	 *
	 * @param array $customer_data Customer array to be prepared.
	 *
	 * @returns array The customer array to be sent to Square.
	 */
	private function prepare_for_update( $customer_data ) {

		$prepared_customer = array();
		$has_name = ! rgempty( 'given_name', $customer_data ) && ! rgempty( 'family_name', $customer_data );

		$address_fields = array( 'address_line_1', 'address_line_2', 'locality', 'administrative_district_level_1', 'postal_code', 'country' );
		$has_address = false;
		foreach ( $address_fields as $address_field ) {
			if ( ! rgempty( $address_field, $customer_data['address'] ) ) {
				$has_address = true;
			}
		}

		$prepared_customer['email_address']  = $customer_data['email_address'];

		if ( $has_name ) {
			$prepared_customer['given_name']  = $customer_data['given_name'];
			$prepared_customer['family_name'] = $customer_data['family_name'];
		}
		if ( $has_address ) {
			$prepared_customer['address'] = $customer_data['address'];

			// Square doesn't accept an empty country field. Unset if empty.
			if ( rgempty( 'country', $prepared_customer['address'] ) ) {
				unset( $prepared_customer['address']['country'] );
			}
		}

		return $prepared_customer;
	}

	/**
	 * Compiles the customer information fields mapped in the feed and submitted in the form.
	 *
	 * @since 1.5.3
	 *
	 * @param array $form Current form object.
	 * @param array $feed Current feed object.
	 * @param array $entry Current entry object.
	 */
	private function get_customer_data( $form, $feed, $entry ) {

		$country_name = $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_address_country' ) );
		$country_code = ! empty( $country_name ) ? \GFCommon::get_country_code( $country_name ) : '';

		$customer_data = array(
			'email_address' => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_email' ) ),
			'given_name'    => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_first_name' ) ),
			'family_name'   => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_last_name' ) ),
			'address'       => array(
				'address_line_1'                  => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_address_line1' ) ),
				'address_line_2'                  => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_address_line2' ) ),
				'locality'                        => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_address_city' ) ),
				'administrative_district_level_1' => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_address_state' ) ),
				'postal_code'                     => $this->addon->get_field_value( $form, $entry, rgars( $feed, 'meta/billingInformation_address_zip' ) ),
				'country'                         => $country_code,
			),
		);

		return $customer_data;
	}

	/**
	 * Handle error objects, prepare for response.
	 *
	 * @since 1.3
	 *
	 * @param WP_Error $error WP Error object.
	 *
	 * @return array
	 */
	public function handle_error( $error ) {

		$this->addon->log_error( print_r( $error, true ) );

		$error_data = array(
			'is_success'    => false,
			'error_message' => __( 'An unknown error has occurred.', 'gravityformssquare' ),
		);

		if ( is_wp_error( $error ) ) {
			$error_data['error_message'] = $error->get_error_message();
		}

		return $error_data;
	}


	/**
	 * Loads dependencies for this class if they cannot be autoloaded.
	 *
	 * @since 1.3
	 */
	private function load_class_dependencies() {
		// Load required model/controller classes.
		require_once gf_square()->get_base_path() . '/includes/subscriptions/class-plan.php';
		require_once gf_square()->get_base_path() . '/includes/subscriptions/class-subscription.php';
	}
}
