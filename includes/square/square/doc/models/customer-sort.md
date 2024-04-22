## Customer Sort

Specifies how searched customers profiles are sorted, including the sort key and sort order.

### Structure

`CustomerSort`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `field` | [`?string (CustomerSortField)`](/doc/models/customer-sort-field.md) | Optional | Specifies customer attributes as the sort key to customer profiles returned from a search. |
| `order` | [`?string (SortOrder)`](/doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. |

### Example (as JSON)

```json
{
  "field": null,
  "order": null
}
```

