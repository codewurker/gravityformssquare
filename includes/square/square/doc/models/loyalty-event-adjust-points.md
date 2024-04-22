## Loyalty Event Adjust Points

Provides metadata when the event `type` is `ADJUST_POINTS`.

### Structure

`LoyaltyEventAdjustPoints`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `loyaltyProgramId` | `?string` | Optional | The Square-assigned ID of the [loyalty program](#type-LoyaltyProgram). |
| `points` | `int` |  | The number of points added or removed. |
| `reason` | `?string` | Optional | The reason for the adjustment of points. |

### Example (as JSON)

```json
{
  "loyalty_program_id": null,
  "points": 236,
  "reason": null
}
```

