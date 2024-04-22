<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Subscriptions;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Catalog_Object;
use Gravity_Forms\Gravity_Forms_Square\API\Subscriptions\Plan_Data;

/**
 * Gravity Forms Square Subscription Plan.
 *
 * @see https://developer.squareup.com/docs/subscriptions-api/setup-plan
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Plan extends Catalog_Object {

	/**
	 * Default type
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $type = 'SUBSCRIPTION_PLAN';

	/**
	 * Default Plan ID.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $id = '#plan';

	/**
	 * Instance of Subscription Plan_Data.
	 *
	 * @since 1.3
	 *
	 * @var Plan_Data
	 */
	public $subscription_plan_data;

	/**
	 * Plan constructor.
	 *
	 * @since 1.3
	 *
	 * @param array $plan Plan properties.
	 */
	public function __construct( $plan ) {
		$this->hydrate( $plan );
	}

	/**
	 * Build Plan Data object and set object properties.
	 *
	 * @since 1.3
	 *
	 * @param array $plan_data Array of data to use for hydration.
	 */
	public function hydrate( $plan_data ) {
		if ( rgar( $plan_data, 'id' ) ) {
			$this->id = $plan_data['id'];
		}

		// Build Plan Data.
		$this->subscription_plan_data = new Plan_Data();

		// Set Name.
		if ( rgar( $plan_data, 'name' ) ) {
			$this->subscription_plan_data->set_name( $plan_data['name'] );
		}

		// Set Phase(s).
		if ( rgar( $plan_data, 'phases' ) ) {
			$this->subscription_plan_data->set_phases( $plan_data['phases'] );
		} elseif ( rgar( $plan_data, 'phase' ) ) {
			$this->subscription_plan_data->add_phase( $plan_data['phase'] );
		}
	}

}
