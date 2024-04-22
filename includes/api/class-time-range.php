<?php

namespace Gravity_Forms\Gravity_Forms_Square\API;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Time Range.
 *
 * @see https://developer.squareup.com/reference/square/objects/TimeRange
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Time_Range extends Hydration {

	/**
	 * A datetime value in RFC 3339 format indicating when the time range starts.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $start_at;

	/**
	 * A datetime value in RFC 3339 format indicating when the time range ends.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $end_at;

}
