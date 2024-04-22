## V1 Page Cell

V1PageCell

### Structure

`V1PageCell`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `pageId` | `?string` | Optional | The unique identifier of the page the cell is included on. |
| `row` | `?int` | Optional | The row of the cell. Always an integer between 0 and 4, inclusive. |
| `column` | `?int` | Optional | The column of the cell. Always an integer between 0 and 4, inclusive. |
| `objectType` | [`?string (V1PageCellObjectType)`](/doc/models/v1-page-cell-object-type.md) | Optional | -  |
| `objectId` | `?string` | Optional | The unique identifier of the entity represented in the cell. Not present for cells with an object_type of PLACEHOLDER. |
| `placeholderType` | [`?string (V1PageCellPlaceholderType)`](/doc/models/v1-page-cell-placeholder-type.md) | Optional | -  |

### Example (as JSON)

```json
{
  "page_id": null,
  "row": null,
  "column": null,
  "object_type": null,
  "object_id": null,
  "placeholder_type": null
}
```

