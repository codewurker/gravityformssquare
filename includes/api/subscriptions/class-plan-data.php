<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Subscriptions;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Subscriptions\Phase;

/**
 * Gravity Forms Square Subscription Plan Data.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogObject#definition__property-subscription_plan_data
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Plan_Data {

	/**
	 * The name of the plan.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $name;

	/**
	 * A list of SubscriptionPhase containing the SubscriptionPhase for this plan.
	 *
	 * @since 1.3
	 *
	 * @var array Contains Subscription Phase objects
	 */
	public $phases = array();

	/**
	 * Sets the Plan name.
	 *
	 * @since 1.3
	 *
	 * @param string $name Plan Name.
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Set the phases array.
	 *
	 * @param array $phases Array of Phases.
	 */
	public function set_phases( array $phases ) {
		foreach ( $phases as $phase ) {
			$this->add_phase( $phase );
		}
	}

	/**
	 * Add a new phase to phases array.
	 *
	 * @since 1.3
	 *
	 * @param Phase $phase Subscription Phase object.
	 */
	public function add_phase( $phase ) {
		if ( ! $phase instanceof Phase ) {
			$phase = new Phase( $phase );
		}

		$this->phases[] = $phase;
	}
}
