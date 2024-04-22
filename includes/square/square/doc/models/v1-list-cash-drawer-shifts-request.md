## V1 List Cash Drawer Shifts Request

### Structure

`V1ListCashDrawerShiftsRequest`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `order` | [`?string (SortOrder)`](/doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. |
| `beginTime` | `?string` | Optional | The beginning of the requested reporting period, in ISO 8601 format. Default value: The current time minus 90 days. |
| `endTime` | `?string` | Optional | The beginning of the requested reporting period, in ISO 8601 format. Default value: The current time. |

### Example (as JSON)

```json
{
  "order": null,
  "begin_time": null,
  "end_time": null
}
```

