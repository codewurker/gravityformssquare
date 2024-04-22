## Catalog Query Sorted Attribute

### Structure

`CatalogQuerySortedAttribute`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `attributeName` | `string` |  | The attribute whose value should be used as the sort key. |
| `initialAttributeValue` | `?string` | Optional | The first attribute value to be returned by the query. Ascending sorts will return only<br>objects with this value or greater, while descending sorts will return only objects with this value<br>or less. If unset, start at the beginning (for ascending sorts) or end (for descending sorts). |
| `sortOrder` | [`?string (SortOrder)`](/doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. |

### Example (as JSON)

```json
{
  "attribute_name": "attribute_name4",
  "initial_attribute_value": null,
  "sort_order": null
}
```

