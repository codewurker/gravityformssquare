## Catalog Item Modifier List Info

Controls the properties of a `CatalogModifierList` as it applies to
this `CatalogItem`.

### Structure

`CatalogItemModifierListInfo`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `modifierListId` | `string` |  | The ID of the `CatalogModifierList` controlled by this `CatalogModifierListInfo`. |
| `modifierOverrides` | [`?(CatalogModifierOverride[])`](/doc/models/catalog-modifier-override.md) | Optional | A set of `CatalogModifierOverride` objects that override whether a given `CatalogModifier` is enabled by default. |
| `minSelectedModifiers` | `?int` | Optional | If 0 or larger, the smallest number of `CatalogModifier`s that must be selected from this `CatalogModifierList`. |
| `maxSelectedModifiers` | `?int` | Optional | If 0 or larger, the largest number of `CatalogModifier`s that can be selected from this `CatalogModifierList`. |
| `enabled` | `?bool` | Optional | If `true`, enable this `CatalogModifierList`. The default value is `true`. |

### Example (as JSON)

```json
{
  "modifier_list_id": "modifier_list_id6",
  "modifier_overrides": null,
  "min_selected_modifiers": null,
  "max_selected_modifiers": null,
  "enabled": null
}
```

