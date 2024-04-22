## Terminal Checkout Query Filter

### Structure

`TerminalCheckoutQueryFilter`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `deviceId` | `?string` | Optional | `TerminalCheckout`s associated with a specific device. If no device is specified then all<br>`TerminalCheckout`s for the merchant will be displayed. |
| `createdAt` | [`?TimeRange`](/doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC-3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevent endpoint-specific documentation to determine<br>how time ranges are handled. |
| `status` | `?string` | Optional | Filtered results with the desired status of the `TerminalCheckout`<br>Options: PENDING, IN\_PROGRESS, CANCELED, COMPLETED |

### Example (as JSON)

```json
{
  "device_id": null,
  "created_at": null,
  "status": null
}
```

