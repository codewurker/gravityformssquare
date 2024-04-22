<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Abstracts;

defined( 'ABSPATH' ) || die();

/**
 * Gravity Forms Square Catalog Object.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogObject
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
abstract class Catalog_Object extends Hydration {

	/**
	 * The type of this object. Each object type has expected properties expressed in a structured format within its corresponding *_data field below.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $type;

	/**
	 * An identifier to reference this object in the catalog.
	 *
	 * When a new CatalogObject is inserted, the client should set the id to a temporary identifier starting with a "#" character. Other objects being inserted or updated within the same request may use this identifier to refer to the new object.
	 *
	 * When the server receives the new object, it will supply a unique identifier that replaces the temporary identifier for all future references.
	 *
	 * @since 1.3
	 *
	 * @var string Required.
	 */
	public $id;

	/**
	 * Read only Last modification timestamp in RFC 3339 format, e.g., "2016-08-15T23:59:33.123Z" would indicate the UTC time (denoted by Z) of August 15, 2016 at 23:59:33 and 123 milliseconds.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	private $updated_at;

	/**
	 * The version of the object. When updating an object, the version supplied must match the version in the database, otherwise the write will be rejected as conflicting.
	 *
	 * @since 1.3
	 *
	 * @var integer
	 */
	public $version;

	/**
	 * If true, the object has been deleted from the database. Must be false for new objects being inserted. When deleted, the updated_at field will equal the deletion time.
	 *
	 * @since 1.3
	 *
	 * @var bool
	 */
	public $is_deleted;

}
