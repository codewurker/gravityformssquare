<?php

namespace Gravity_Forms\Gravity_Forms_Square\API;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;
use Gravity_Forms\Gravity_forms_Square\API\Catalog_Query\Catalog_Query;

/**
 * Gravity Forms Square Catalog Search Object.
 *
 * @see https://developer.squareup.com/reference/square/catalog-api/search-catalog-objects
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Catalog_Search extends Hydration {

	/**
	 * The pagination cursor returned in the previous response. Leave unset for an initial request.
	 *
	 * @see https://developer.squareup.com/docs/basics/api101/pagination
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $cursor;

	/**
	 * The desired set of object types to appear in the search results.
	 *
	 * @see https://developer.squareup.com/reference/square/enums/CatalogObjectType
	 *
	 * @since 1.3
	 *
	 * @var string[]
	 */
	public $object_types;

	/**
	 * If true, deleted objects will be included in the results. Deleted objects will have their is_deleted field set to true.
	 *
	 * @since 1.3
	 *
	 * @var bool
	 */
	public $include_deleted_objects = false;

	/**
	 * If true, the response will include additional objects that are related to the requested object, as follows:
	 *
	 * If a CatalogItem is returned in the object field of the response, its associated CatalogCategory, CatalogTax objects, CatalogImage objects and CatalogModifierList objects will be included in the related_objects field of the response.
	 *
	 * If a CatalogItemVariation is returned in the object field of the response, its parent CatalogItem will be included in the related_objects field of the response.
	 *
	 * @since 1.3
	 *
	 * @var bool
	 */
	public $include_related_objects = false;

	/**
	 * Return objects modified after this timestamp, in RFC 3339 format, e.g., 2016-09-04T23:59:33.123Z. The timestamp is exclusive - objects with a timestamp equal to begin_time will not be included in the response.
	 *
	 * @since 1.3
	 *
	 * @var string
	 */
	public $begin_time;

	/**
	 * A query to be used to filter or sort the results. If no query is specified, the entire catalog will be returned.
	 *
	 * @since 1.3
	 *
	 * @var Catalog_Query
	 */
	public $query;

	/**
	 * A limit on the number of results to be returned in a single page. The limit is advisory - the implementation may return more or fewer results. If the supplied limit is negative, zero, or is higher than the maximum limit of 1,000, it will be ignored.
	 *
	 * @since 1.3
	 *
	 * @var int
	 */
	public $limit;

	/**
	 * Sets the Catalog Query parameter.
	 *
	 * @since 1.3
	 *
	 * @param array|Catalog_Query $query
	 */
	public function set_query( $query ) {
		if ( ! $query instanceof Catalog_Query ) {
			$query = new Catalog_Query( $query );
		}

		$this->query = $query;
	}
}
