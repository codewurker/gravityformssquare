## Create Loyalty Reward Request

A request to create a loyalty reward.

### Structure

`CreateLoyaltyRewardRequest`

### Fields

| Name | Type | Description |
|  --- | --- | --- |
| `reward` | [`LoyaltyReward`](/doc/models/loyalty-reward.md) | -  |
| `idempotencyKey` | `string` | A unique string that identifies this `CreateLoyaltyReward` request.<br>Keys can be any valid string, but must be unique for every request. |

### Example (as JSON)

```json
{
  "reward": {
    "loyalty_account_id": "5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd",
    "reward_tier_id": "e1b39225-9da5-43d1-a5db-782cdd8ad94f",
    "order_id": "RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY"
  },
  "idempotency_key": "18c2e5ea-a620-4b1f-ad60-7b167285e451"
}
```

