## V1 Payment Discount

V1PaymentDiscount

### Structure

`V1PaymentDiscount`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `?string` | Optional | The discount's name. |
| `appliedMoney` | [`?V1Money`](/doc/models/v1-money.md) | Optional | -  |
| `discountId` | `?string` | Optional | The ID of the applied discount, if available. Discounts applied in older versions of Square Register might not have an ID. |

### Example (as JSON)

```json
{
  "name": null,
  "applied_money": null,
  "discount_id": null
}
```

