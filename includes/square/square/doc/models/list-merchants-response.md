## List Merchants Response

The response object returned by the [ListMerchant](#endpoint-listmerchant) endpoint.

### Structure

`ListMerchantsResponse`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Information on errors encountered during the request. |
| `merchant` | [`?(Merchant[])`](/doc/models/merchant.md) | Optional | The requested `Merchant` entities. |
| `cursor` | `?int` | Optional | If the  response is truncated, the cursor to use in next  request to fetch next set of objects. |

### Example (as JSON)

```json
{
  "merchant": [
    {
      "id": "DM7VKY8Q63GNP",
      "business_name": "Apple A Day",
      "country": "US",
      "language_code": "en-US",
      "currency": "USD",
      "status": "ACTIVE"
    }
  ]
}
```

