## Search Orders Filter

Filtering criteria to use for a SearchOrders request. Multiple filters
will be ANDed together.

### Structure

`SearchOrdersFilter`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `stateFilter` | [`?SearchOrdersStateFilter`](/doc/models/search-orders-state-filter.md) | Optional | Filter by current Order `state`. |
| `dateTimeFilter` | [`?SearchOrdersDateTimeFilter`](/doc/models/search-orders-date-time-filter.md) | Optional | Filter for `Order` objects based on whether their `CREATED_AT`,<br>`CLOSED_AT` or `UPDATED_AT` timestamps fall within a specified time range.<br>You can specify the time range and which timestamp to filter for. You can filter<br>for only one time range at a time.<br><br>For each time range, the start time and end time are inclusive. If the end time<br>is absent, it defaults to the time of the first request for the cursor.<br><br>__Important:__ If you use the DateTimeFilter in a SearchOrders query,<br>you must also set the `sort_field` in [OrdersSort](#type-searchorderordersort)<br>to the same field you filter for. For example, if you set the `CLOSED_AT` field<br>in DateTimeFilter, you must also set the `sort_field` in SearchOrdersSort to<br>`CLOSED_AT`. Otherwise, SearchOrders will throw an error.<br>[Learn more about filtering orders by time range](https://developer.squareup.com/docs/orders-api/manage-orders#important-note-on-filtering-orders-by-time-range). |
| `fulfillmentFilter` | [`?SearchOrdersFulfillmentFilter`](/doc/models/search-orders-fulfillment-filter.md) | Optional | Filter based on [Order Fulfillment](#type-orderfulfillment) information. |
| `sourceFilter` | [`?SearchOrdersSourceFilter`](/doc/models/search-orders-source-filter.md) | Optional | Filter based on order `source` information. |
| `customerFilter` | [`?SearchOrdersCustomerFilter`](/doc/models/search-orders-customer-filter.md) | Optional | Filter based on Order `customer_id` and any Tender `customer_id`<br>associated with the Order. Does not filter based on the<br>[FulfillmentRecipient](#type-orderfulfillmentrecipient) `customer_id`. |

### Example (as JSON)

```json
{
  "state_filter": null,
  "date_time_filter": null,
  "fulfillment_filter": null,
  "source_filter": null,
  "customer_filter": null
}
```

