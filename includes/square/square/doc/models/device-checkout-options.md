## Device Checkout Options

### Structure

`DeviceCheckoutOptions`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `deviceId` | `string` |  | The unique Id of the device intended for this `TerminalCheckout`.<br>The Id can be retrieved from /v2/devices api. |
| `skipReceiptScreen` | `?bool` | Optional | Instruct the device to skip the receipt screen. Defaults to false. |
| `tipSettings` | [`?TipSettings`](/doc/models/tip-settings.md) | Optional | -  |

### Example (as JSON)

```json
{
  "device_id": "device_id6",
  "skip_receipt_screen": null,
  "tip_settings": null
}
```

