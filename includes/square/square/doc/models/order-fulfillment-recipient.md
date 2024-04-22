## Order Fulfillment Recipient

Contains information on the recipient of a fulfillment.

### Structure

`OrderFulfillmentRecipient`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `customerId` | `?string` | Optional | The Customer ID of the customer associated with the fulfillment.<br><br>If `customer_id` is provided, the fulfillment recipient's `display_name`,<br>`email_address`, and `phone_number` are automatically populated from the<br>targeted customer profile. If these fields are set in the request, the request<br>values will override the information from the customer profile. If the<br>targeted customer profile does not contain the necessary information and<br>these fields are left unset, the request will result in an error. |
| `displayName` | `?string` | Optional | The display name of the fulfillment recipient.<br><br>If provided, overrides the value pulled from the customer profile indicated by `customer_id`. |
| `emailAddress` | `?string` | Optional | The email address of the fulfillment recipient.<br><br>If provided, overrides the value pulled from the customer profile indicated by `customer_id`. |
| `phoneNumber` | `?string` | Optional | The phone number of the fulfillment recipient.<br><br>If provided, overrides the value pulled from the customer profile indicated by `customer_id`. |
| `address` | [`?Address`](/doc/models/address.md) | Optional | Represents a physical address. |

### Example (as JSON)

```json
{
  "customer_id": null,
  "display_name": null,
  "email_address": null,
  "phone_number": null,
  "address": null
}
```

