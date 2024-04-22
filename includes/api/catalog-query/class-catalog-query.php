<?php

namespace Gravity_Forms\Gravity_Forms_Square\API\Catalog_Query;

defined( 'ABSPATH' ) || die();

use Gravity_Forms\Gravity_Forms_Square\API\Abstracts\Hydration;

/**
 * Gravity Forms Square Catalog Query for Catalog Search.
 *
 * @see https://developer.squareup.com/reference/square/objects/CatalogQuery
 *
 * @since     1.3
 * @package   Gravity_Forms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2021, Rocketgenius
 */
class Catalog_Query extends Hydration {

	/**
	 * A query expression to sort returned query result by the given attribute.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CatalogQuerySortedAttribute
	 *
	 * @since 1.3
	 *
	 * @var Sorted_Attribute
	 */
	public $sorted_attribute_query;

	/**
	 * An exact query expression to return objects with attribute name and value matching the specified attribute name and value exactly. Value matching is case insensitive.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryExact
	 *
	 * @since 1.3
	 *
	 * @var Exact
	 */
	public $exact_query;

	/**
	 * A set query expression to return objects with attribute name and value matching the specified attribute name and any of the specified attribute values exactly. Value matching is case insensitive.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CatalogQuerySet
	 *
	 * @since 1.3
	 *
	 * @var Set
	 */
	public $set_query;

	/**
	 * A prefix query expression to return objects with attribute values that have a prefix matching the specified string value. Value matching is case insensitive.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryPrefix
	 *
	 * @since 1.3
	 *
	 * @var Prefix
	 */
	public $prefix_query;

	/**
	 * A range query expression to return objects with numeric values that lie in the specified range.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryRange
	 *
	 * @since 1.3
	 *
	 * @var Range
	 */
	public $range_query;

	/**
	 * A text query expression to return objects whose searchable attributes contain all of the given keywords, irrespective of their order. For example, if a CatalogItem contains custom attribute values of {"name": "t-shirt"} and {"description": "Small, Purple"}, the query filter of {"keywords": ["shirt", "sma", "purp"]} returns this item.
	 *
	 * @see https://developer.squareup.com/reference/square/objects/CatalogQueryText
	 *
	 * @since 1.3
	 *
	 * @var Text
	 */
	public $text_query;

	/**
	 * Sets the Sorted Attribute query property.
	 *
	 * @since 1.3
	 *
	 * @param array|Sorted_Attribute $sorted_attribute
	 */
	public function set_sorted_attribute( $sorted_attribute ) {
		if ( ! $sorted_attribute instanceof Sorted_Attribute ) {
			$sorted_attribute = new Sorted_Attribute( $sorted_attribute );
		}
		$this->sorted_attribute_query = $sorted_attribute;
	}

	/**
	 * Sets the exact query property.
	 *
	 * @since 1.3
	 *
	 * @param array|Exact $exact
	 */
	public function set_exact( $exact ) {
		if ( ! $exact instanceof Exact ) {
			$exact = new Exact( $exact );
		}
		$this->exact_query = $exact;
	}

	/**
	 * Sets the set query property.
	 *
	 * @since 1.3
	 *
	 * @param array|Set $set
	 */
	public function set_set( $set ) {
		if ( ! $set instanceof Set ) {
			$set = new Set( $set );
		}
		$this->set_query = $set;
	}

	/**
	 * Sets the prefix query property.
	 *
	 * @since 1.3
	 *
	 * @param array|Prefix $prefix
	 */
	public function set_prefix( $prefix ) {
		if ( ! $prefix instanceof Prefix ) {
			$prefix = new Prefix( $prefix );
		}
		$this->prefix_query = $prefix;
	}

	/**
	 * Sets the range query property.
	 *
	 * @since 1.3
	 *
	 * @param array|Range $range
	 */
	public function set_range( $range ) {
		if ( ! $range instanceof Range ) {
			$range = new Range( $range );
		}
		$this->range_query = $range;
	}

	/**
	 * Sets the text query property.
	 *
	 * @since 1.3
	 *
	 * @param array|Text $text
	 */
	public function set_text( $text ) {
		if ( ! $text instanceof Text ) {
			$text = new Text( $text );
		}
		$this->text_query = $text;
	}
}
