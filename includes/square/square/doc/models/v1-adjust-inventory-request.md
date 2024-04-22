## V1 Adjust Inventory Request

V1AdjustInventoryRequest

### Structure

`V1AdjustInventoryRequest`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `quantityDelta` | `?float` | Optional | The number to adjust the variation's quantity by. |
| `adjustmentType` | [`?string (V1AdjustInventoryRequestAdjustmentType)`](/doc/models/v1-adjust-inventory-request-adjustment-type.md) | Optional | -  |
| `memo` | `?string` | Optional | A note about the inventory adjustment. |

### Example (as JSON)

```json
{
  "quantity_delta": null,
  "adjustment_type": null,
  "memo": null
}
```

