## Get Terminal Checkout Response

### Structure

`GetTerminalCheckoutResponse`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Information on errors encountered during the request. |
| `checkout` | [`?TerminalCheckout`](/doc/models/terminal-checkout.md) | Optional | -  |

### Example (as JSON)

```json
{
  "checkout": {
    "id": "08YceKh7B3ZqO",
    "amount_money": {
      "amount": 2610,
      "currency": "USD"
    },
    "reference_id": "id11572",
    "note": "A brief note",
    "device_options": {
      "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003",
      "print_receipt": false,
      "tip_settings": {
        "allow_tipping": false
      },
      "skip_receipt_screen": false
    },
    "status": "IN_PROGRESS",
    "created_at": "2020-04-06T16:39:32.545Z",
    "updated_at": "2020-04-06T16:39:323.001Z",
    "app_id": "APP_ID",
    "deadline_duration": "PT10M"
  }
}
```

