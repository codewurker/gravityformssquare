## Loyalty Reward

### Structure

`LoyaltyReward`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the loyalty reward. |
| `status` | [`?string (LoyaltyRewardStatus)`](/doc/models/loyalty-reward-status.md) | Optional | The status of the loyalty reward. |
| `loyaltyAccountId` | `string` |  | The Square-assigned ID of the [loyalty account](#type-LoyaltyAccount) to which the reward belongs. |
| `rewardTierId` | `string` |  | The Square-assigned ID of the [reward tier](#type-LoyaltyProgramRewardTier) used to create the reward. |
| `points` | `?int` | Optional | The number of loyalty points used for the reward. |
| `orderId` | `?string` | Optional | The Square-assigned ID of the [order](#type-Order) to which the reward is attached. |
| `createdAt` | `?string` | Optional | The timestamp when the reward was created, in RFC 3339 format. |
| `updatedAt` | `?string` | Optional | The timestamp when the reward was last updated, in RFC 3339 format. |
| `redeemedAt` | `?string` | Optional | The timestamp when the reward was redeemed, in RFC 3339 format. |

### Example (as JSON)

```json
{
  "id": null,
  "status": null,
  "loyalty_account_id": "loyalty_account_id0",
  "reward_tier_id": "reward_tier_id6",
  "points": null,
  "order_id": null,
  "created_at": null,
  "updated_at": null,
  "redeemed_at": null
}
```

