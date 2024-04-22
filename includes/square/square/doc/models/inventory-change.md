## Inventory Change

Represents a single physical count, inventory, adjustment, or transfer
that is part of the history of inventory changes for a particular
`CatalogObject`.

### Structure

`InventoryChange`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `type` | [`?string (InventoryChangeType)`](/doc/models/inventory-change-type.md) | Optional | Indicates how the inventory change was applied to a tracked quantity of items. |
| `physicalCount` | [`?InventoryPhysicalCount`](/doc/models/inventory-physical-count.md) | Optional | Represents the quantity of an item variation that is physically present<br>at a specific location, verified by a seller or a seller's employee. For example,<br>a physical count might come from an employee counting the item variations on<br>hand or from syncing with an external system. |
| `adjustment` | [`?InventoryAdjustment`](/doc/models/inventory-adjustment.md) | Optional | Represents a change in state or quantity of product inventory at a<br>particular time and location. |
| `transfer` | [`?InventoryTransfer`](/doc/models/inventory-transfer.md) | Optional | Represents the transfer of a quantity of product inventory at a<br>particular time from one location to another. |

### Example (as JSON)

```json
{
  "type": null,
  "physical_count": null,
  "adjustment": null,
  "transfer": null
}
```

