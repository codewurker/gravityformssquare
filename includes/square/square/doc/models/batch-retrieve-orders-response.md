## Batch Retrieve Orders Response

Defines the fields that are included in the response body of
a request to the BatchRetrieveOrders endpoint.

### Structure

`BatchRetrieveOrdersResponse`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orders` | [`?(Order[])`](/doc/models/order.md) | Optional | The requested orders. This will omit any requested orders that do not exist. |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Any errors that occurred during the request. |

### Example (as JSON)

```json
{
  "orders": [
    {
      "id": "CAISEM82RcpmcFBM0TfOyiHV3es",
      "location_id": "057P5VYJ4A5X1",
      "reference_id": "my-order-001",
      "line_items": [
        {
          "uid": "945986d1-9586-11e6-ad5a-28cfe92138cf",
          "name": "Awesome product",
          "quantity": "1",
          "base_price_money": {
            "amount": 1599,
            "currency": "USD"
          },
          "total_money": {
            "amount": 1599,
            "currency": "USD"
          }
        },
        {
          "uid": "a8f4168c-9586-11e6-bdf0-28cfe92138cf",
          "name": "Another awesome product",
          "quantity": "3",
          "base_price_money": {
            "amount": 2000,
            "currency": "USD"
          },
          "total_money": {
            "amount": 6000,
            "currency": "USD"
          }
        }
      ],
      "total_money": {
        "amount": 7599,
        "currency": "USD"
      }
    }
  ]
}
```

