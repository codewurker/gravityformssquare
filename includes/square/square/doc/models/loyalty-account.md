## Loyalty Account

Describes a loyalty account. For more information, see
[Loyalty Overview](https://developer.squareup.com/docs/docs/loyalty/overview).

### Structure

`LoyaltyAccount`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the loyalty account. |
| `mappings` | [`LoyaltyAccountMapping[]`](/doc/models/loyalty-account-mapping.md) |  | The list of mappings that the account is associated with.<br>Currently, a buyer can only be mapped to a loyalty account using<br>a phone number. Therefore, the list can only have one mapping. |
| `programId` | `string` |  | The Square-assigned ID of the [loyalty program](#type-LoyaltyProgram) to which the account belongs. |
| `balance` | `?int` | Optional | The available point balance in the loyalty account. |
| `lifetimePoints` | `?int` | Optional | The total points accrued during the lifetime of the account. |
| `customerId` | `?string` | Optional | The Square-assigned ID of the [customer](#type-Customer) that is associated with the account. |
| `enrolledAt` | `?string` | Optional | The timestamp when enrollment occurred, in RFC 3339 format. |
| `createdAt` | `?string` | Optional | The timestamp when the loyalty account was created, in RFC 3339 format. |
| `updatedAt` | `?string` | Optional | The timestamp when the loyalty account was last updated, in RFC 3339 format. |

### Example (as JSON)

```json
{
  "id": null,
  "mappings": [
    {
      "id": null,
      "type": "type6",
      "value": "value6",
      "created_at": null
    }
  ],
  "program_id": "program_id0",
  "balance": null,
  "lifetime_points": null,
  "customer_id": null,
  "enrolled_at": null,
  "created_at": null,
  "updated_at": null
}
```

