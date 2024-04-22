## Cancel Terminal Checkout Response

### Structure

`CancelTerminalCheckoutResponse`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Information on errors encountered during the request. |
| `checkout` | [`?TerminalCheckout`](/doc/models/terminal-checkout.md) | Optional | -  |

### Example (as JSON)

```json
{
  "checkout": {
    "id": "S1yDlPQx7slqO",
    "amount_money": {
      "amount": 123,
      "currency": "USD"
    },
    "reference_id": "id36815",
    "device_options": {
      "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003",
      "tip_settings": {
        "allow_tipping": true
      },
      "skip_receipt_screen": true
    },
    "status": "CANCELED",
    "cancel_reason": "SELLER_CANCELED",
    "created_at": "2020-03-16T15:31:19.934Z",
    "updated_at": "2020-03-16T15:31:45.787Z",
    "app_id": "APP_ID",
    "deadline_duration": "PT10M"
  }
}
```

