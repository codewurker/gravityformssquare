## List Payments Request

Retrieves a list of payments taken by the account making the request.

Max results per page: 100

### Structure

`ListPaymentsRequest`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `beginTime` | `?string` | Optional | Timestamp for the beginning of the reporting period, in RFC 3339 format.<br>Inclusive. Default: The current time minus one year. |
| `endTime` | `?string` | Optional | Timestamp for the end of the requested reporting period, in RFC 3339 format.<br><br>Default: The current time. |
| `sortOrder` | `?string` | Optional | The order in which results are listed.<br><br>- `ASC` - oldest to newest<br>- `DESC` - newest to oldest (default). |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for the original query.<br><br>See [Pagination](https://developer.squareup.com/docs/basics/api101/pagination) for more information. |
| `locationId` | `?string` | Optional | Limit results to the location supplied. By default, results are returned<br>for all locations associated with the merchant. |
| `total` | `?int` | Optional | The exact amount in the total_money for a `Payment`. |
| `last4` | `?string` | Optional | The last 4 digits of `Payment` card. |
| `cardBrand` | `?string` | Optional | The brand of `Payment` card. For example, `VISA` |

### Example (as JSON)

```json
{}
```

