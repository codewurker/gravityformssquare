## V1 Payment Surcharge

V1PaymentSurcharge

### Structure

`V1PaymentSurcharge`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `?string` | Optional | The name of the surcharge. |
| `appliedMoney` | [`?V1Money`](/doc/models/v1-money.md) | Optional | -  |
| `rate` | `?string` | Optional | The amount of the surcharge as a percentage. The percentage is provided as a string representing the decimal equivalent of the percentage. For example, "0.7" corresponds to a 7% surcharge. Exactly one of rate or amount_money should be set. |
| `amountMoney` | [`?V1Money`](/doc/models/v1-money.md) | Optional | -  |
| `type` | [`?string (V1PaymentSurchargeType)`](/doc/models/v1-payment-surcharge-type.md) | Optional | -  |
| `taxable` | `?bool` | Optional | Indicates whether the surcharge is taxable. |
| `taxes` | [`?(V1PaymentTax[])`](/doc/models/v1-payment-tax.md) | Optional | The list of taxes that should be applied to the surcharge. |
| `surchargeId` | `?string` | Optional | A Square-issued unique identifier associated with the surcharge. |

### Example (as JSON)

```json
{
  "name": null,
  "applied_money": null,
  "rate": null,
  "amount_money": null,
  "type": null,
  "taxable": null,
  "taxes": null,
  "surcharge_id": null
}
```

