## Catalog Custom Attribute Definition Selection Config Custom Attribute Selection

A named selection for this `SELECTION`-type custom attribute definition.

### Structure

`CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `uid` | `?string` | Optional | Unique ID set by Square. |
| `name` | `string` |  | Selection name, unique within `allowed_selections`.<br>Required. Min length of 1, max length of 255. |

### Example (as JSON)

```json
{
  "uid": null,
  "name": "name0"
}
```

