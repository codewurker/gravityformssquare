## Inventory Count

Represents Square's estimated quantity of items in a particular state at a
particular location based on the known history of physical counts and
inventory adjustments.

### Structure

`InventoryCount`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `catalogObjectId` | `?string` | Optional | The Square generated ID of the<br>`CatalogObject` being tracked. |
| `catalogObjectType` | `?string` | Optional | The `CatalogObjectType` of the<br>`CatalogObject` being tracked. Tracking is only<br>supported for the `ITEM_VARIATION` type. |
| `state` | [`?string (InventoryState)`](/doc/models/inventory-state.md) | Optional | Indicates the state of a tracked item quantity in the lifecycle of goods. |
| `locationId` | `?string` | Optional | The Square ID of the [Location](#type-location) where the related<br>quantity of items are being tracked. |
| `quantity` | `?string` | Optional | The number of items affected by the estimated count as a decimal string.<br>Can support up to 5 digits after the decimal point.<br><br>_Important_: The Point of Sale app and Dashboard do not currently support<br>decimal quantities. If a Point of Sale app or Dashboard attempts to read a<br>decimal quantity on inventory counts or adjustments, the quantity will be rounded<br>down to the nearest integer. For example, `2.5` will become `2`, and `-2.5`<br>will become `-3`.<br>Read [Decimal Quantities (BETA)](https://developer.squareup.com/docs/docs/inventory-api/what-it-does#decimal-quantities-beta) for more information. |
| `calculatedAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format that indicates when Square<br>received the most recent physical count or adjustment that had an affect<br>on the estimated count. |

### Example (as JSON)

```json
{
  "catalog_object_id": null,
  "catalog_object_type": null,
  "state": null,
  "location_id": null,
  "quantity": null,
  "calculated_at": null
}
```

