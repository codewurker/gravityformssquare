## Loyalty Event Type Filter

Filter events by event type.

### Structure

`LoyaltyEventTypeFilter`

### Fields

| Name | Type | Description |
|  --- | --- | --- |
| `types` | [`string[] (LoyaltyEventType)`](/doc/models/loyalty-event-type.md) | The loyalty event types used to filter the result.<br>If multiple values are specified, the endpoint uses a<br>logical OR to combine them.<br>See [LoyaltyEventType](#type-loyaltyeventtype) for possible values |

### Example (as JSON)

```json
{
  "types": [
    "DELETE_REWARD",
    "ADJUST_POINTS",
    "EXPIRE_POINTS"
  ]
}
```

