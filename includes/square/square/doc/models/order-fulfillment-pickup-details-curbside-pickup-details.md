## Order Fulfillment Pickup Details Curbside Pickup Details

Specific details for curbside pickup.

### Structure

`OrderFulfillmentPickupDetailsCurbsidePickupDetails`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `curbsideDetails` | `?string` | Optional | Specific details for curbside pickup, such as parking number, vehicle model, etc. |
| `buyerArrivedAt` | `?string` | Optional | The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., "2016-09-04T23:59:33.123Z",<br>indicating when the buyer arrived and is waiting for pickup. |

### Example (as JSON)

```json
{
  "curbside_details": null,
  "buyer_arrived_at": null
}
```

