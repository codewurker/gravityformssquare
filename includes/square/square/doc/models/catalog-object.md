## Catalog Object

The wrapper object for object types in the Catalog data model. The type
of a particular `CatalogObject` is determined by the value of
`type` and only the corresponding data field may be set.

- if type = `ITEM`, only `item_data` will be populated and it will contain a valid `CatalogItem` object.
- if type = `ITEM_VARIATION`, only `item_variation_data` will be populated and it will contain a valid `CatalogItemVariation` object.
- if type = `MODIFIER`, only `modifier_data` will be populated and it will contain a valid `CatalogModifier` object.
- if type = `MODIFIER_LIST`, only `modifier_list_data` will be populated and it will contain a valid `CatalogModifierList` object.
- if type = `CATEGORY`, only `category_data` will be populated and it will contain a valid `CatalogCategory` object.
- if type = `DISCOUNT`, only `discount_data` will be populated and it will contain a valid `CatalogDiscount` object.
- if type = `TAX`, only `tax_data` will be populated and it will contain a valid `CatalogTax` object.
- if type = `IMAGE`, only `image_data` will be populated and it will contain a valid `CatalogImage` object.
- if type = `QUICK_AMOUNTS_SETTINGS`, only `quick_amounts_settings_data` will be populated and will contain a valid `CatalogQuickAmountsSettings` object.

For a more detailed discussion of the Catalog data model, please see the
[Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide.

### Structure

`CatalogObject`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `type` | [`string (CatalogObjectType)`](/doc/models/catalog-object-type.md) |  | Possible types of CatalogObjects returned from the Catalog, each<br>containing type-specific properties in the `*_data` field corresponding to the object type. |
| `id` | `string` |  | An identifier to reference this object in the catalog. When a new `CatalogObject`<br>is inserted, the client should set the id to a temporary identifier starting with<br>a "`#`" character. Other objects being inserted or updated within the same request<br>may use this identifier to refer to the new object.<br><br>When the server receives the new object, it will supply a unique identifier that<br>replaces the temporary identifier for all future references. |
| `updatedAt` | `?string` | Optional | Last modification [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates) in RFC 3339 format, e.g., `"2016-08-15T23:59:33.123Z"`<br>would indicate the UTC time (denoted by `Z`) of August 15, 2016 at 23:59:33 and 123 milliseconds. |
| `version` | `?int` | Optional | The version of the object. When updating an object, the version supplied<br>must match the version in the database, otherwise the write will be rejected as conflicting. |
| `isDeleted` | `?bool` | Optional | If `true`, the object has been deleted from the database. Must be `false` for new objects<br>being inserted. When deleted, the `updated_at` field will equal the deletion time. |
| `customAttributeValues` | [`?array`](/doc/models/catalog-custom-attribute-value.md) | Optional | Application-defined key/value attributes that are set at a global (location-independent) level.<br>Custom Attribute Values are intended to store additional information about a Catalog Object<br>or associations with an entity in another system. Do not use custom attributes<br>to store any sensitive information (personally identifiable information, card details, etc.).<br><br>For CustomAttributesDefinitions defined by the app making the request, the map key is the key defined in the<br>`CatalogCustomAttributeDefinition` (e.g. “reference_id”). For custom attributes created by other apps, the map key is<br>the key defined in `CatalogCustomAttributeDefinition` prefixed with the application ID and a colon<br>(eg. “abcd1234:reference_id”). |
| `catalogV1Ids` | [`?(CatalogV1Id[])`](/doc/models/catalog-v1-id.md) | Optional | The Connect v1 IDs for this object at each location where it is present, where they<br>differ from the object's Connect V2 ID. The field will only be present for objects that<br>have been created or modified by legacy APIs. |
| `presentAtAllLocations` | `?bool` | Optional | If `true`, this object is present at all locations (including future locations), except where specified in<br>the `absent_at_location_ids` field. If `false`, this object is not present at any locations (including future locations),<br>except where specified in the `present_at_location_ids` field. If not specified, defaults to `true`. |
| `presentAtLocationIds` | `?(string[])` | Optional | A list of locations where the object is present, even if `present_at_all_locations` is `false`. |
| `absentAtLocationIds` | `?(string[])` | Optional | A list of locations where the object is not present, even if `present_at_all_locations` is `true`. |
| `imageId` | `?string` | Optional | Identifies the `CatalogImage` attached to this `CatalogObject`. |
| `itemData` | [`?CatalogItem`](/doc/models/catalog-item.md) | Optional | An item (i.e., product family) in the Catalog object model. |
| `categoryData` | [`?CatalogCategory`](/doc/models/catalog-category.md) | Optional | A category to which a `CatalogItem` belongs in the `Catalog` object model. |
| `itemVariationData` | [`?CatalogItemVariation`](/doc/models/catalog-item-variation.md) | Optional | An item variation (i.e., product) in the Catalog object model. Each item<br>may have a maximum of 250 item variations. |
| `taxData` | [`?CatalogTax`](/doc/models/catalog-tax.md) | Optional | A tax in the Catalog object model. |
| `discountData` | [`?CatalogDiscount`](/doc/models/catalog-discount.md) | Optional | A discount in the Catalog object model. |
| `modifierListData` | [`?CatalogModifierList`](/doc/models/catalog-modifier-list.md) | Optional | A modifier list in the Catalog object model. A `CatalogModifierList`<br>contains `CatalogModifier` objects that can be applied to a `CatalogItem` at<br>the time of sale.<br><br>For example, a modifier list "Condiments" that would apply to a "Hot Dog"<br>`CatalogItem` might contain `CatalogModifier`s "Ketchup", "Mustard", and "Relish".<br>The `selection_type` field specifies whether or not multiple selections from<br>the modifier list are allowed. |
| `modifierData` | [`?CatalogModifier`](/doc/models/catalog-modifier.md) | Optional | A modifier in the Catalog object model. |
| `timePeriodData` | [`?CatalogTimePeriod`](/doc/models/catalog-time-period.md) | Optional | Represents a time period - either a single period or a repeating period. |
| `productSetData` | [`?CatalogProductSet`](/doc/models/catalog-product-set.md) | Optional | Represents a collection of catalog objects for the purpose of applying a<br>`PricingRule`. Including a catalog object will include all of its subtypes.<br>For example, including a category in a product set will include all of its<br>items and associated item variations in the product set. Including an item in<br>a product set will also include its item variations. |
| `pricingRuleData` | [`?CatalogPricingRule`](/doc/models/catalog-pricing-rule.md) | Optional | Defines how prices are modified or set for items that match the pricing rule<br>during the active time period. |
| `imageData` | [`?CatalogImage`](/doc/models/catalog-image.md) | Optional | An image file to use in Square catalogs. Can be associated with catalog<br>items, item variations, and categories. |
| `measurementUnitData` | [`?CatalogMeasurementUnit`](/doc/models/catalog-measurement-unit.md) | Optional | Represents the unit used to measure a `CatalogItemVariation` and<br>specifies the precision for decimal quantities. |
| `itemOptionData` | [`?CatalogItemOption`](/doc/models/catalog-item-option.md) | Optional | A group of variations for a `CatalogItem`. |
| `itemOptionValueData` | [`?CatalogItemOptionValue`](/doc/models/catalog-item-option-value.md) | Optional | An enumerated value that can link a<br>`CatalogItemVariation` to an item option as one of<br>its item option values. |
| `customAttributeDefinitionData` | [`?CatalogCustomAttributeDefinition`](/doc/models/catalog-custom-attribute-definition.md) | Optional | Contains information defining a custom attribute. Custom attributes are<br>intended to store additional information about a catalog object or to associate a<br>catalog object with an entity in another system. Do not use custom attributes<br>to store any sensitive information (personally identifiable information, card details, etc.).<br>[Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-attributes) |
| `quickAmountsSettingsData` | [`?CatalogQuickAmountsSettings`](/doc/models/catalog-quick-amounts-settings.md) | Optional | A parent Catalog Object model represents a set of Quick Amounts and the settings control the amounts. |

### Example (as JSON)

```json
{
  "type": "CUSTOM_ATTRIBUTE_DEFINITION",
  "id": "id0",
  "updated_at": null,
  "version": null,
  "is_deleted": null,
  "custom_attribute_values": null,
  "catalog_v1_ids": null,
  "present_at_all_locations": null,
  "present_at_location_ids": null,
  "absent_at_location_ids": null,
  "image_id": null,
  "item_data": null,
  "category_data": null,
  "item_variation_data": null,
  "tax_data": null,
  "discount_data": null,
  "modifier_list_data": null,
  "modifier_data": null,
  "time_period_data": null,
  "product_set_data": null,
  "pricing_rule_data": null,
  "image_data": null,
  "measurement_unit_data": null,
  "item_option_data": null,
  "item_option_value_data": null,
  "custom_attribute_definition_data": null,
  "quick_amounts_settings_data": null
}
```

