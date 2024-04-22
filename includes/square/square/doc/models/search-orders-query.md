## Search Orders Query

Contains query criteria for the search.

### Structure

`SearchOrdersQuery`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `filter` | [`?SearchOrdersFilter`](/doc/models/search-orders-filter.md) | Optional | Filtering criteria to use for a SearchOrders request. Multiple filters<br>will be ANDed together. |
| `sort` | [`?SearchOrdersSort`](/doc/models/search-orders-sort.md) | Optional | Sorting criteria for a SearchOrders request. Results can only be sorted<br>by a timestamp field. |

### Example (as JSON)

```json
{
  "filter": null,
  "sort": null
}
```

