## Customer Query

Represents a query (including filtering criteria, sorting criteria, or both) used to search
for customer profiles.

### Structure

`CustomerQuery`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `filter` | [`?CustomerFilter`](/doc/models/customer-filter.md) | Optional | Represents a set of `CustomerQuery` filters used to limit the set of<br>`Customers` returned by `SearchCustomers`. |
| `sort` | [`?CustomerSort`](/doc/models/customer-sort.md) | Optional | Specifies how searched customers profiles are sorted, including the sort key and sort order. |

### Example (as JSON)

```json
{
  "filter": null,
  "sort": null
}
```

