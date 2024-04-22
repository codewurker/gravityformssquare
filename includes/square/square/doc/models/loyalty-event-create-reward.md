## Loyalty Event Create Reward

Provides metadata when the event `type` is `CREATE_REWARD`.

### Structure

`LoyaltyEventCreateReward`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `loyaltyProgramId` | `string` |  | The ID of the [loyalty program](#type-LoyaltyProgram). |
| `rewardId` | `?string` | Optional | The Square-assigned ID of the created [loyalty reward](#type-LoyaltyReward).<br>This field is returned only if the event source is `LOYALTY_API`. |
| `points` | `int` |  | The loyalty points used to create the reward. |

### Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "reward_id": null,
  "points": 236
}
```

