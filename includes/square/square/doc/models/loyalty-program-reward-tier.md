## Loyalty Program Reward Tier

Describes a loyalty program reward tier.

### Structure

`LoyaltyProgramRewardTier`

### Fields

| Name | Type | Description |
|  --- | --- | --- |
| `id` | `string` | The Square-assigned ID of the reward tier. |
| `points` | `int` | The points exchanged for the reward tier. |
| `name` | `string` | The name of the reward tier. |
| `definition` | [`LoyaltyProgramRewardDefinition`](/doc/models/loyalty-program-reward-definition.md) | Provides details about the loyalty program reward tier definition. |
| `createdAt` | `string` | The timestamp when the reward tier was created, in RFC 3339 format. |

### Example (as JSON)

```json
{
  "id": "id0",
  "points": 236,
  "name": "name0",
  "definition": {
    "scope": "ORDER",
    "discount_type": "FIXED_AMOUNT",
    "percentage_discount": null,
    "catalog_object_ids": null,
    "fixed_discount_money": null,
    "max_discount_money": null
  },
  "created_at": "created_at2"
}
```

