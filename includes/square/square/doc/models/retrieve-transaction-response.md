## Retrieve Transaction Response

Defines the fields that are included in the response body of
a request to the [RetrieveTransaction](#endpont-retrievetransaction) endpoint.

One of `errors` or `transaction` is present in a given response (never both).

### Structure

`RetrieveTransactionResponse`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Any errors that occurred during the request. |
| `transaction` | [`?Transaction`](/doc/models/transaction.md) | Optional | Represents a transaction processed with Square, either with the<br>Connect API or with Square Point of Sale.<br><br>The `tenders` field of this object lists all methods of payment used to pay in<br>the transaction. |

### Example (as JSON)

```json
{
  "transaction": {
    "id": "KnL67ZIwXCPtzOrqj0HrkxMF",
    "location_id": "18YC4JDH91E1H",
    "created_at": "2016-03-10T22:57:56Z",
    "tenders": [
      {
        "id": "MtZRYYdDrYNQbOvV7nbuBvMF",
        "location_id": "18YC4JDH91E1H",
        "transaction_id": "KnL67ZIwXCPtzOrqj0HrkxMF",
        "created_at": "2016-03-10T22:57:56Z",
        "note": "some optional note",
        "amount_money": {
          "amount": 5000,
          "currency": "USD"
        },
        "processing_fee_money": {
          "amount": 138,
          "currency": "USD"
        },
        "type": "CARD",
        "card_details": {
          "status": "CAPTURED",
          "card": {
            "card_brand": "VISA",
            "last_4": "1111"
          },
          "entry_method": "KEYED"
        },
        "additional_recipients": [
          {
            "location_id": "057P5VYJ4A5X1",
            "description": "Application fees",
            "amount_money": {
              "amount": 20,
              "currency": "USD"
            }
          }
        ]
      }
    ],
    "reference_id": "some optional reference id",
    "product": "EXTERNAL_API"
  }
}
```

