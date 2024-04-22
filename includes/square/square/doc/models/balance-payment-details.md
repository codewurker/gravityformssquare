## Balance Payment Details

Reflects the current status of a balance payment.

### Structure

`BalancePaymentDetails`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `accountId` | `?string` | Optional | ID for the account used to fund the payment. |
| `status` | `?string` | Optional | The balance payment’s current state. Can be `COMPLETED` or `FAILED`. |

### Example (as JSON)

```json
{
  "account_id": null,
  "status": null
}
```

