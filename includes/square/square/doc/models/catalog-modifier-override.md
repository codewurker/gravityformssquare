## Catalog Modifier Override

### Structure

`CatalogModifierOverride`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `modifierId` | `string` |  | The ID of the `CatalogModifier` whose default behavior is being overridden. |
| `onByDefault` | `?bool` | Optional | If `true`, this `CatalogModifier` should be selected by default for this `CatalogItem`. |

### Example (as JSON)

```json
{
  "modifier_id": "modifier_id2",
  "on_by_default": null
}
```

