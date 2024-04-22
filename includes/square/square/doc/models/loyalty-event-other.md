## Loyalty Event Other

Provides metadata when the event `type` is `OTHER`.

### Structure

`LoyaltyEventOther`

### Fields

| Name | Type | Description |
|  --- | --- | --- |
| `loyaltyProgramId` | `string` | The Square-assigned ID of the [loyalty program](#type-LoyaltyProgram). |
| `points` | `int` | The number of points added or removed. |

### Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "points": 236
}
```

