<?php
/**
 * Gravity Forms Square API Library Wrapper.
 *
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */

// Client.
use Square\Exceptions\ApiException;
use Square\Http\ApiResponse;

// GF Square Classes.
use Gravity_Forms\Gravity_Forms_Square\API\Customer;
use Gravity_Forms\Gravity_Forms_Square\API\Customer_Card;
use Gravity_Forms\Gravity_Forms_Square\API\Catalog_Search;
use Gravity_Forms\Gravity_Forms_Square\API\Customer_Search;
use Gravity_Forms\Gravity_Forms_Square\API\Subscriptions\Plan;
use Gravity_Forms\Gravity_Forms_Square\API\Subscriptions\Subscription;

/**
 * Square API Library Wrapper Class.
 *
 * Exposes required functionality from the Square API and returns localized WP_Error objects
 * instead of API Exceptions.
 *
 * @since     1.0
 */
class GF_Square_API {

	/**
	 * Square authentication data.
	 *
	 * @since 1.0
	 *
	 * @var array $auth_data Square authentication data.
	 */
	protected $auth_data = null;

	/**
	 * Business locations.
	 *
	 * @since 1.0
	 *
	 * @var array[]
	 */
	protected $locations = null;

	/**
	 * Last API Call Exception.
	 *
	 * @since 1.0
	 *
	 * @depecated 1.6
	 *
	 * @var ApiException
	 */
	protected $last_exception = null;

	/**
	 * Square API URL.
	 *
	 * @since  1.3
	 *
	 * @var string $api_url API URL.
	 */
	protected $api_url;

	/**
	 * Indicates if the request and response data should be logged.
	 *
	 * @since 1.6
	 *
	 * @var bool
	 */
	protected $debug_logging = false;

	/**
	 * Null or an instance of the Gravity Forms Square Add-On.
	 *
	 * @since 1.6
	 *
	 * @var GF_Square
	 */
	protected $addon;

	/**
	 * Initialize API library.
	 *
	 * @since 1.0.0
	 * @since 1.6   Added the $addon param.
	 *
	 * @param array          $auth_data Square authentication data.
	 * @param string         $mode      live or sandbox.
	 * @param null|GF_Square $addon     Null or an instance of the Gravity Forms Square Add-On.
	 */
	public function __construct( $auth_data, $mode = 'live', $addon = null ) {
		$this->api_url   = $mode != 'live' ? 'https://connect.squareupsandbox.com' : 'https://connect.squareup.com';
		$this->auth_data = $auth_data;
		$this->addon     = empty( $addon ) ? gf_square() : $addon;

		if ( defined( 'GF_SQUARE_DEBUG' ) ) {
			$this->debug_logging = (bool) GF_SQUARE_DEBUG;
		}
	}

	/**
	 * Make API request.
	 *
	 * @since  1.3
	 *
	 * @param string $action        Request action.
	 * @param array  $options       Request options.
	 * @param string $method        HTTP method. Defaults to GET.
	 * @param int    $response_code Expected HTTP response code. Defaults to 200.
	 *
	 * @return array|string|WP_Error
	 */
	private function make_request( $action, $options = array(), $method = 'GET', $response_code = 200 ) {
		// Prepare request URL.
		$request_url = trailingslashit( $this->api_url ) . $action;

		// Default headers.
		$headers = array(
			'Content-Type' => 'application/json',
		);

		// Add Authorization header if credentials are set.
		if ( ! empty( $this->auth_data ) ) {
			$headers['Authorization'] = 'Bearer ' . $this->get_access_token();
		}

		// Get body and headers if set in $options.
		$headers = rgar( $options, 'headers' ) ? wp_parse_args( $options['headers'], $headers ) : $headers;
		$body    = rgar( $options, 'body' ) ? $options['body'] : $options;

		// Add query parameters.
		if ( 'GET' === $method ) {
			$request_url = add_query_arg( urlencode_deep( $options ), $request_url );
		}

		// Build request arguments.
		$args = array(
			'method'    => $method,
			'headers'   => $headers,
			/**
			 * Filters if SSL verification should occur.
			 *
			 * @since 1.0
			 *
			 * @param bool false If the SSL certificate should be verified. Defalts to false.
			 *
			 * @return bool
			 */
			'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
			/**
			 * Sets the HTTP timeout, in seconds, for the request.
			 *
			 * @since 1.0
			 *
			 * @param int    30           The timeout limit, in seconds. Defaults to 30.
			 * @param string $request_url The request URL.
			 *
			 * @return int
			 */
			'timeout'   => apply_filters( 'http_request_timeout', 30, $request_url ),
		);

		// Add body to non-GET requests.
		if ( 'GET' !== $method && ! empty( $body ) ) {
			$args['body'] = ( $args['headers']['Content-Type'] === 'application/json' ) ? json_encode( $body ) : $body;
		}

		// Execute API request.
		$response = wp_remote_request( $request_url, $args );

		// If API request returns a WordPress error, return.
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		// Convert JSON response to array.
		$response_body = wp_remote_retrieve_body( $response );
		if ( ! empty( $response_body ) ) {
			$response_body = $this->addon->maybe_decode_json( $response_body );
		} else {
			$response_body = array();
		}

		// If result response code is not the expected response code, return error.
		if ( wp_remote_retrieve_response_code( $response ) !== $response_code ) {
			return $this->generate_wp_error( $response, $response_body );
		}

		return $response_body;
	}

	/**
	 * Generate WP_Error object from API Response.
	 *
	 * @param array $response
	 * @param array $response_body
	 *
	 * @return WP_Error
	 */
	private function generate_wp_error( $response, $response_body ) {
		$error_code = wp_remote_retrieve_response_code( $response );

		// Use the error description in the body if available (it's usually more human readable messages).
		if ( $this->is_response_prop_array( $response_body, 'errors' ) ) {
			foreach ( $response_body['errors'] as $error ) {
				// Usually only returns 1 error.
				$error_message = $error['detail'];
				$error_code    = $error['code'];
				break;
			}
		} else {
			$error_message = wp_remote_retrieve_response_message( $response );
		}

		return new WP_Error( $error_code, $error_message, $response_body );
	}

	/**
	 * Determines if the specified key is defined in the response, and it is a non-empty array.
	 *
	 * @since 1.6
	 *
	 * @param array  $response_body The JSON decoded response body.
	 * @param string $key           The key to find in the array.
	 *
	 * @return bool
	 */
	public function is_response_prop_array( $response_body, $key ) {
		return ! empty( $response_body[ $key ] ) && is_array( $response_body[ $key ] );
	}

	/**
	 * Filters locations for active ones that have credit card processing enabled.
	 *
	 * @since 1.0.0
	 *
	 * @return array active locations that support credit card processing.
	 */
	public function get_active_locations() {
		$gf_currency = strtolower( GFCommon::get_currency() );
		$locations   = array();
		foreach ( $this->locations as $location ) {
			if ( rgar( $location, 'status' ) !== 'ACTIVE' ||
				! is_array( rgar( $location, 'capabilities' ) ) ||
				! in_array( 'CREDIT_CARD_PROCESSING', $location['capabilities'] ) ||
				strtolower( rgar( $location, 'currency' ) ) !== $gf_currency ) {
				continue;
			}

			$locations[] = array(
				'label' => rgar( $location, 'name' ),
				'value' => rgar( $location, 'id' ),
			);

		}

		return $locations;
	}

	/**
	 * Determines if the given location has the given ID.
	 *
	 * @since 1.6
	 *
	 * @param array  $location    The location to be checked.
	 * @param string $location_id Business Location ID.
	 *
	 * @return bool
	 */
	public function location_id_matches( $location, $location_id ) {
		return $location_id === rgar( $location, 'id' );
	}

	/**
	 * Gets the currency of a given business location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location_id Business Location ID.
	 *
	 * @return bool|string
	 */
	public function get_location_currency( $location_id ) {
		foreach ( $this->locations as $location ) {
			if ( $this->location_id_matches( $location, $location_id ) ) {
				return rgar( $location, 'currency', false );
			}
		}

		return false;
	}

	/**
	 * Gets the Name of a given business location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location_id Business Location ID.
	 *
	 * @return null|string
	 */
	public function get_location_name( $location_id ) {
		foreach ( $this->locations as $location ) {
			if ( $this->location_id_matches( $location, $location_id ) ) {
				return rgar( $location, 'business_name' );
			}
		}

		return null;
	}

	/**
	 * Gets the country of a given business location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $location_id Business Location ID.
	 *
	 * @return bool|string
	 */
	public function get_location_country( $location_id ) {
		foreach ( $this->locations as $location ) {
			if ( $this->location_id_matches( $location, $location_id ) ) {
				return rgars( $location, 'address/country', false );
			}
		}

		return false;
	}

	/**
	 * Retrieves a list of business locations associated with the account.
	 *
	 * This function is also used to make sure the token is not revoked.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function fetch_locations() {
		$response = $this->make_request( 'v2/locations' );
		if ( is_wp_error( $response ) ) {
			$this->addon->log_debug( __METHOD__ . '(): Unable to get locations; ' . $response->get_error_message() );

			return false;
		}

		if ( ! $this->is_response_prop_array( $response, 'locations' ) ) {
			$this->addon->log_debug( __METHOD__ . '(): Unable to get locations.' );

			return false;
		}

		$this->addon->log_debug( __METHOD__ . sprintf( '(): Retrieved %d location(s).', count( $response['locations'] ) ) );
		$this->locations = $response['locations'];

		return true;
	}

	/**
	 * Gets a merchant's name
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @return string|WP_Error
	 */
	public function get_merchant_name() {
		$merchant_id = $this->get_merchant_id();

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $merchant_id => ' . print_r( $merchant_id, true ) );
		}

		$response = $this->make_request( 'v2/merchants/' . $merchant_id );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgars( $response, 'merchant/business_name' );
	}

	/**
	 * Creates a payment on selected Square business location.
	 *
	 * @since 1.0.0
	 * @since 1.0.7 returns an array instead of a Payment object.
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param array $payment_data Payment details.
	 *
	 * @return array|WP_Error The created payment or a WP error object.
	 */
	public function create_payment( $payment_data ) {
		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $payment_data => ' . print_r( $payment_data, true ) );
		}

		$response = $this->make_request( 'v2/payments', $payment_data, 'POST' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'payment' );
	}

	/**
	 * Completes a payment that was authorized before.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param string $payment_id Payment Object ID.
	 *
	 * @return array|WP_Error
	 */
	public function complete_payment( $payment_id ) {
		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $payment_id => ' . print_r( $payment_id, true ) );
		}

		$response = $this->make_request( "v2/payments/{$payment_id}/complete", array(), 'POST' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'payment' );
	}

	/**
	 * Fetches a Square payment by id
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param string $payment_id The payment ID.
	 *
	 * @return array|WP_Error
	 */
	public function get_payment( $payment_id ) {
		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $payment_id => ' . print_r( $payment_id, true ) );
		}

		$response = $this->make_request( 'v2/payments/' . $payment_id );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'payment' );
	}

	/**
	 * Create a refund request for a payment.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API and added the $payment param.
	 *
	 * @param string $transaction_id Payment ID.
	 * @param array  $payment        The Square payment properties.
	 *
	 * @return array|WP_Error
	 */
	public function create_refund( $transaction_id, $payment = array() ) {
		if ( empty( $payment ) ) {
			$payment = $this->get_payment( $transaction_id );

			if ( is_wp_error( $payment ) ) {
				return $payment;
			}
		}

		$payment_total  = rgars( $payment, 'total_money/amount', 0 );
		$refunded_money = rgars( $payment, 'refunded_money/amount', 0 );
		$refund_amount  = $payment_total - $refunded_money;

		if ( $refund_amount === 0 ) {
			return new WP_Error( 500, __( 'This payment has already been refunded', 'gravityformssquare' ) );
		}

		$refund_args = $this->set_idempotency_key( array(
			'payment_id'   => $transaction_id,
			'amount_money' => array(
				'amount'   => $refund_amount,
				'currency' => rgar( $payment['total_money'], 'currency' ),
			),
		) );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $refund_args => ' . print_r( $refund_args, true ) );
		}

		$response = $this->make_request( 'v2/refunds', $refund_args, 'POST' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'refund' );
	}

	/**
	 * Gets a refund object by ID.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param string $refund_id Refund ID.
	 *
	 * @return array|WP_Error
	 */
	public function get_refund( $refund_id ) {
		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $refund_id => ' . print_r( $refund_id, true ) );
		}

		$response = $this->make_request( 'v2/refunds/' . $refund_id );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'refund' );
	}

	/**
	 * Retrieves a page of refunds.
	 *
	 * @since 1.6
	 *
	 * @param array $query_args           The request query arguments.
	 * @param false $return_full_response Indicates if the full response body should be returned instead of just the refunds property.
	 *
	 * @return array|WP_Error
	 */
	public function get_refunds( $query_args = array(), $return_full_response = false ) {
		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $query_args => ' . print_r( $query_args, true ) );
		}

		$response = $this->make_request( 'v2/refunds', $query_args );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( $return_full_response || is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'refunds', array() );
	}

	/**
	 * Gets refund information for a location within a set time period.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param string|null $begin_time Start of time period when refunds were created.
	 * @param string|null $end_time   End of time period when refunds were created.
	 *
	 * @return array|WP_Error
	 */
	public function get_completed_refunds( $begin_time = null, $end_time = null ) {
		$query_args = array(
			'sort_order'  => 'DESC',
			'status'      => 'COMPLETED',
			'source_type' => 'CARD',
		);

		if ( ! empty( $begin_time ) ) {
			$query_args['begin_time'] = $begin_time;
		}

		if ( ! empty( $end_time ) ) {
			$query_args['end_time'] = $end_time;
		}

		$response = $this->get_refunds( $query_args, true );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( ! $this->is_response_prop_array( $response, 'refunds' ) ) {
			return array();
		}

		$refunds = $response['refunds'];

		while ( ! empty( $response['cursor'] ) ) {
			$query_args['cursor'] = $response['cursor'];
			$response             = $this->get_refunds( $query_args, true );

			if ( is_wp_error( $response ) || ! $this->is_response_prop_array( $response, 'refunds' ) ) {
				return $refunds;
			}

			$refunds = array_merge( $refunds, $response['refunds'] );
		}

		return $refunds;
	}

	/**
	 * Creates a square customer
	 *
	 * @since 1.0
	 * @since 1.6 Updated to use the REST API.
	 *
	 * @param array $customer_data Customer parameters.
	 *
	 * @return string|WP_Error
	 */
	public function create_customer( $customer_data ) {
		$customer_data = $this->set_idempotency_key( $customer_data );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $customer_data => ' . print_r( $customer_data, true ) );
		}

		$response = $this->make_request( 'v2/customers', $customer_data, 'POST' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgars( $response, 'customer/id' );
	}

	/**
	 * Returns a customer object by ID.
	 *
	 * @since 1.5.3
	 *
	 * @param string $customer_id The customer ID to retrieve.
	 *
	 * @return array|WP_Error
	 */
	public function get_customer( $customer_id ) {
		$result = $this->make_request( "v2/customers/{$customer_id}" );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		return $result['customer'];
	}

	/**
	 * Updates a customer given their ID and the new customer data array
	 *
	 * @since 1.5.3
	 *
	 * @param string $customer_id Customer ID to be updated.
	 * @param array  $customer_data New customer data.
	 *
	 * @return array|WP_Error
	 */
	public function update_customer( $customer_id, $customer_data ) {

		return $this->make_request( "v2/customers/{$customer_id}", $customer_data, 'PUT' );
	}

	/**
	 * Creates an Order.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param string $location Order location.
	 * @param array  $order_data Order parameters.
	 *
	 * @return string|WP_Error
	 */
	public function create_order( $location, $order_data ) {
		if ( empty( $order_data['location_id'] ) ) {
			$order_data['location_id'] = $location;
		}

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $order_data => ' . print_r( $order_data, true ) );
		}

		$response = $this->make_request( 'v2/orders', $order_data, 'POST' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgars( $response, 'order/id' );
	}

	/**
	 * Retrieves the specified order.
	 *
	 * @since 1.6
	 *
	 * @param string $order_id The order ID.
	 *
	 * @return array|WP_Error|null
	 */
	public function get_order( $order_id ) {
		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $order_id => ' . print_r( $order_id, true ) );
		}

		$response = $this->make_request( 'v2/orders/' . $order_id );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'order' );
	}

	/**
	 * Updates an order's reference ID with entry ID.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @param string $location     Order location ID.
	 * @param string $order_id     Order ID.
	 * @param string $reference_id Order reference ID.
	 *
	 * @return array|WP_Error
	 */
	public function update_order_reference_id( $location, $order_id, $reference_id ) {
		$order = $this->get_order( $order_id );

		if ( is_wp_error( $order ) ) {
			return $order;
		}

		$update_data = $this->set_idempotency_key( array(
			'order' => array(
				'location_id'  => $location,
				'version'      => rgar( $order, 'version' ),
				'reference_id' => $reference_id,
			)
		) );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $update_data => ' . print_r( $update_data, true ) );
		}

		$response = $this->make_request( 'v2/orders/' . $order_id , $update_data, 'PUT' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgar( $response, 'order' );
	}

	/**
	 * Gets refresh token from auth data.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null token string or null if it doesn't exit.
	 */
	public function get_refresh_token() {
		return isset( $this->auth_data['refresh_token'] ) ? $this->auth_data['refresh_token'] : null;
	}

	/**
	 * Gets access token from auth data.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null token string or null if it doesn't exit.
	 */
	public function get_access_token() {
		return isset( $this->auth_data['access_token'] ) ? $this->auth_data['access_token'] : null;
	}

	/**
	 * Gets authorized merchant's ID from aut data.
	 *
	 * @since 1.0.0
	 * @since 1.6   Updated to use the REST API.
	 *
	 * @return string|null merchant's ID string or null if it doesn't exit.
	 */
	public function get_merchant_id() {

		if ( isset( $this->auth_data['merchant_id'] ) ) {
			return $this->auth_data['merchant_id'];
		}

		$response = $this->make_request( 'v2/merchants' );

		if ( $this->debug_logging ) {
			$this->addon->log_debug( __METHOD__ . '(): $response => ' . print_r( $response, true ) );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return rgars( $response, 'merchant/id' );
	}

	/**
	 * Create a Subscription Plan.
	 *
	 * @since 1.3
	 *
	 * @param array $plan Associated array of property value initializing the subscription model.
	 *
	 * @return array|WP_Error
	 */
	public function create_plan( $plan ) {
		$data = $this->set_idempotency_key(
			array(
				'object' => new Plan( $plan ),
			)
		);

		$response = $this->make_request( 'v2/catalog/object', $data, 'POST' );

		return $this->prepare_response( $response, 'catalog_object' );
	}

	/**
	 * Handle return response from API.
	 *
	 * @since 1.3
	 *
	 * @param array|WP_Error $response     API Response.
	 * @param string         $response_key Key to check for in response.
	 *
	 * @return array|WP_Error
	 */
	private function prepare_response( $response, $response_key = null ) {
		if ( is_array( $response ) && $response_key && isset( $response[ $response_key ] ) ) {
			return $response[ $response_key ];
		}

		return $response;
	}

	/**
	 * Sets the unique key for this request.
	 *
	 * @since 1.3
	 *
	 * @param array $data Array of data.
	 *
	 * @return array
	 */
	private function set_idempotency_key( array $data ) {
		if ( empty( $data['idempotency_key'] ) ) {
			$data['idempotency_key'] = $this->generate_idempotency_key();
		}
		return $data;
	}

	/**
	 * Generates an idempotency key.
	 *
	 * @since 1.5
	 *
	 * @return string the idempotency key.
	 */
	public function generate_idempotency_key() {
		if ( function_exists( 'random_bytes' ) ) {
			return bin2hex( random_bytes( 13 ) );
		}

		if ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
			$key = (string) openssl_random_pseudo_bytes( 13 );
			return bin2hex( $key );
		}

		return bin2hex( uniqid() );
	}

	/**
	 * Create a new subscription.
	 *
	 * @link https://developer.squareup.com/reference/square/subscriptions-api/create-subscription
	 * @link https://developer.squareup.com/docs/subscriptions-api/overview#subscription-
	 * object-overview
	 *
	 * @since 1.3
	 *
	 * @param string $location_id       The ID of the location the subscription is associated with.
	 * @param string $plan_id           The ID of the subscription plan.
	 * @param string $customer_id       The ID of the customer profile.
	 * @param string $card_id           The ID of the stored card that will be used for this subscription.
	 * @param array  $subscription_data Additional Subscription properties.
	 *
	 * @return Subscription|WP_Error
	 */
	public function create_subscription( $location_id, $plan_id, $customer_id, $card_id, $subscription_data = array() ) {
		$subscription = new Subscription(
			$this->set_idempotency_key(
				array_merge(
					array(
						'location_id' => $location_id,
						'plan_id'     => $plan_id,
						'customer_id' => $customer_id,
						'card_id'     => $card_id,
					),
					$subscription_data
				)
			)
		);

		$response = $this->make_request( 'v2/subscriptions', $subscription, 'POST' );

		return $this->prepare_response( $response, 'subscription' );
	}

	/**
	 * Cancels a subscription.
	 *
	 * @since 1.3
	 *
	 * @param string $subscription_id The subscription id to be cancelled.
	 */
	public function cancel_subscription( $subscription_id ) {
		return $this->make_request( 'v2/subscriptions/' . $subscription_id . '/cancel', array(), 'POST' );
	}

	/**
	 * Get a single subscription.
	 *
	 * @since 1.3
	 *
	 * @param string $subscription_id The Square Subscription ID.
	 *
	 * @return array|WP_Error
	 */
	public function get_subscription( $subscription_id ) {
		$response = $this->make_request( 'v2/subscriptions/' . $subscription_id );

		return $this->prepare_response( $response, 'subscription' );
	}

	/**
	 * Get an invoice by ID.
	 *
	 * @link https://developer.squareup.com/docs/invoices-api/overview
	 *
	 * @since 1.3
	 *
	 * @param string $invoice_id Square Invoice ID.
	 *
	 * @return array|WP_Error
	 */
	public function get_invoice( $invoice_id ) {
		$response = $this->make_request( 'v2/invoices/' . $invoice_id );

		return $this->prepare_response( $response, 'invoice' );
	}

	/**
	 * Convert the new ApiResponse object to a WP_Error object.
	 *
	 * @since 1.5
	 *
	 * @depecated 1.6
	 *
	 * @param ApiResponse $response the ApiResponse.
	 *
	 * @return WP_Error
	 */
	public function get_wp_error_from_api_response( ApiResponse $response ) {
		_deprecated_function( __METHOD__, '1.6' );
		$errors = $response->getErrors();

		if ( empty( $errors ) ) {
			return new \WP_Error( 'error', 'Could not get response from Square API.' );
		}

		$error = $errors[0];

		return new \WP_Error( $error->getCode(), $error->getDetail() );
	}

	/**
	 * Converts an API exception to wp_error object.
	 *
	 * @since 1.0.0
	 *
	 * @depecated 1.6
	 *
	 * @param ApiException $e Square API exception object.
	 *
	 * @return WP_Error
	 */
	public function get_wp_error( ApiException $e ) {
		_deprecated_function( __METHOD__, '1.6' );
		$errors        = null;
		$response_body = $e->getResponseBody();
		if ( is_object( $response_body ) && isset( $response_body->errors ) ) {
			$errors = $response_body->errors;
		}

		if ( ! is_array( $errors ) || ! is_object( $errors[0] ) || ! isset( $errors[0]->code ) ) {
			$message = $this->get_error_code_message( '' );
		} else {
			$message = $this->get_error_code_message( $errors[0]->code );
		}

		return new WP_Error( $e->getCode(), $message, $e );
	}

	/**
	 * Search Catalog objects.
	 *
	 * @since 1.3
	 *
	 * @param array $search_params Search Parameters array.
	 *
	 * @return array|WP_Error
	 */
	public function search_catalog( array $search_params ) {
		return $this->make_request( 'v2/catalog/search', new Catalog_Search( $search_params ), 'POST' );
	}

	/**
	 * Search Customers.
	 *
	 * @since 1.3
	 *
	 * @param array $search_params Search Parameters array.
	 *
	 * @return array|WP_Error
	 */
	public function search_customers( array $search_params ) {
		return $this->make_request( 'v2/customers/search', new Customer_Search( $search_params ), 'POST' );
	}

	/**
	 * Create Customer Card
	 *
	 * @since 1.3
	 *
	 * @param string $customer_id The Customer ID.
	 *
	 * @return array|WP_Error
	 */
	public function create_customer_card( $customer_id, array $card ) {
		$response = $this->make_request( "v2/customers/{$customer_id}/cards", new Customer_Card( $card ), 'POST' );
		return $this->prepare_response( $response, 'card' );
	}

	/**
	 * Translates an error code to a localized message.
	 *
	 * @param string $code Square API error code string.
	 *
	 * @return string the localized message or the original code if no message found for it.
	 */
	public function get_error_code_message( $code ) {
		$messages = array(
			'CARD_EXPIRED'                           => esc_html__( 'The card issuer declined the request because the card is expired.', 'gravityformssquare' ),
			'PAN_FAILURE'                            => esc_html__( 'Invalid credit card number.', 'gravityformssquare' ),
			'INSUFFICIENT_FUNDS'                     => esc_html__( 'Card has insufficient funds.', 'gravityformssquare' ),
			'CVV_FAILURE'                            => esc_html__( 'Invalid CVV.', 'gravityformssquare' ),
			'INVALID_POSTAL_CODE'                    => esc_html__( 'Invalid postal code.', 'gravityformssquare' ),
			'INVALID_EXPIRATION'                     => esc_html__( 'The card expiration date is either missing or incorrectly formatted.', 'gravityformssquare' ),
			'INVALID_EXPIRATION_YEAR'                => esc_html__( 'The expiration year for the payment card is invalid.', 'gravityformssquare' ),
			'INVALID_EXPIRATION_DATE'                => esc_html__( 'The expiration date for the payment card is invalid.', 'gravityformssquare' ),
			'BAD_EXPIRATION'                         => esc_html__( 'The card expiration date is either missing or incorrectly formatted.', 'gravityformssquare' ),
			'CARD_NOT_SUPPORTED'                     => esc_html__( 'The card is not supported in the merchant\'s geographic region.', 'gravityformssquare' ),
			'UNSUPPORTED_CARD_BRAND'                 => esc_html__( 'The credit card provided is not from a supported issuer.', 'gravityformssquare' ),
			'UNSUPPORTED_ENTRY_METHOD'               => esc_html__( 'The entry method for the credit card (swipe, dip, tap) is not supported.', 'gravityformssquare' ),
			'CHIP_INSERTION_REQUIRED'                => esc_html__( 'The card issuer requires that the card be read using a chip reader.', 'gravityformssquare' ),
			'INVALID_ENCRYPTED_CARD'                 => esc_html__( 'The encrypted card information is invalid.', 'gravityformssquare' ),
			'INVALID_CARD'                           => esc_html__( 'The credit card cannot be validated based on the provided details.', 'gravityformssquare' ),
			'EXPIRATION_FAILURE'                     => esc_html__( 'The card expiration date is either invalid or indicates that the card is expired.', 'gravityformssquare' ),
			'GENERIC_DECLINE'                        => esc_html__( 'The credit card was decline by the issuer for an unspecified reason.', 'gravityformssquare' ),
			'INVALID_ACCOUNT'                        => esc_html__( 'The credit card was decline by the issuer for an unspecified reason.', 'gravityformssquare' ),
			'INVALID_ENUM_VALUE'                     => esc_html__( 'Required Data is missing.', 'gravityformssquare' ),
			'VALUE_EMPTY'                            => esc_html__( 'Required Data is missing.', 'gravityformssquare' ),
			'VALUE_TOO_HIGH'                         => esc_html__( 'Payment amount is greater than the account supported maximum.', 'gravityformssquare' ),
			'VALUE_TOO_LOW'                          => esc_html__( 'Payment amount is less than the account supported minimum.', 'gravityformssquare' ),
			'ADDRESS_VERIFICATION_FAILURE'           => esc_html__( 'The card issuer declined the request because the postal code is invalid.', 'gravityformssquare' ),
			'CURRENCY_MISMATCH'                      => esc_html__( 'The currency associated with the payment is not valid for the provided funding source.', 'gravityformssquare' ),
			'CARDHOLDER_INSUFFICIENT_PERMISSIONS'    => esc_html__( 'The funding source associated with the payment has limitations on how it can be used. For example, it is only valid for specific merchants or transaction types.', 'gravityformssquare' ),
			'INVALID_LOCATION'                       => esc_html__( 'Payments in this region is not allowed.', 'gravityformssquare' ),
			'TRANSACTION_LIMIT'                      => esc_html__( 'The payment amount violates an associated transaction limit.', 'gravityformssquare' ),
			'VOICE_FAILURE'                          => esc_html__( 'The transaction was declined because the card issuer requires voice authorization from the cardholder.', 'gravityformssquare' ),
			'INVALID_PIN'                            => esc_html__( 'The card issuer declined the request because the PIN is invalid.', 'gravityformssquare' ),
			'MANUALLY_ENTERED_PAYMENT_NOT_SUPPORTED' => esc_html__( 'The payment was declined because manually keying-in the card information is disallowed. The card must be swiped, tapped, or dipped.', 'gravityformssquare' ),
			'AMOUNT_TOO_HIGH'                        => esc_html__( 'The requested payment amount is too high for the provided payment source.', 'gravityformssquare' ),
			'INVALID_CARD_DATA'                      => esc_html__( 'The provided card data is invalid.', 'gravityformssquare' ),
			'INVALID_EMAIL_ADDRESS'                  => esc_html__( 'The provided email address is invalid.', 'gravityformssquare' ),
			'INVALID_PHONE_NUMBER'                   => esc_html__( 'The provided phone number is invalid.', 'gravityformssquare' ),
			'CARD_DECLINED'                          => esc_html__( 'The card was declined.', 'gravityformssquare' ),
			'VERIFY_CVV_FAILURE'                     => esc_html__( 'The CVV could not be verified.', 'gravityformssquare' ),
			'VERIFY_AVS_FAILURE'                     => esc_html__( 'The AVS could not be verified.', 'gravityformssquare' ),
			'CARD_DECLINED_CALL_ISSUER'              => esc_html__( 'The payment card was declined with a request for the card holder to call the issuer.', 'gravityformssquare' ),
			'CARD_DECLINED_VERIFICATION_REQUIRED'    => esc_html__( 'The payment card was declined with a request for additional verification.', 'gravityformssquare' ),
			'ALLOWABLE_PIN_TRIES_EXCEEDED'           => esc_html__( 'The card has exhausted its available pin entry retries set by the card issuer. Resolving the error typically requires the card holder to contact the card issuer.', 'gravityformssquare' ),
			'REFUND_AMOUNT_INVALID'                  => esc_html__( 'The requested refund amount exceeds the amount available to refund.', 'gravityformssquare' ),
			'REFUND_ALREADY_PENDING'                 => esc_html__( 'The payment already has a pending refund.', 'gravityformssquare' ),
			'PAYMENT_NOT_REFUNDABLE'                 => esc_html__( 'The payment is not refundable. For example, a previous refund has already been rejected and no new refunds can be accepted.', 'gravityformssquare' ),
			'RESERVATION_DECLINED'                   => esc_html__( 'The card issuer declined the refund..', 'gravityformssquare' ),

		);

		if ( array_key_exists( $code, $messages ) ) {
			return $messages[ $code ];
		} else {
			return esc_html__( 'An error occurred while processing your request.', 'gravityformssquare' );
		}
	}

	/**
	 * Gets last API call exception if it exists.
	 *
	 * @Since 1.0.0
	 *
	 * @depecated 1.6
	 *
	 * @return ApiException
	 */
	public function get_last_exception() {
		_deprecated_function( __METHOD__, '1.6' );
		return $this->last_exception;
	}
}
