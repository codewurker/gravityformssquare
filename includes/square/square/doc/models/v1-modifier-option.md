## V1 Modifier Option

V1ModifierOption

### Structure

`V1ModifierOption`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `?string` | Optional | The modifier option's unique ID. |
| `name` | `?string` | Optional | The modifier option's name. |
| `priceMoney` | [`?V1Money`](/doc/models/v1-money.md) | Optional | -  |
| `onByDefault` | `?bool` | Optional | If true, the modifier option is the default option in a modifier list for which selection_type is SINGLE. |
| `ordinal` | `?int` | Optional | Indicates the modifier option's list position when displayed in Square Point of Sale and the merchant dashboard. If more than one modifier option in the same modifier list has the same ordinal value, those options are displayed in alphabetical order. |
| `modifierListId` | `?string` | Optional | The ID of the modifier list the option belongs to. |
| `v2Id` | `?string` | Optional | The ID of the CatalogObject in the Connect v2 API. Objects that are shared across multiple locations share the same v2 ID. |

### Example (as JSON)

```json
{
  "id": null,
  "name": null,
  "price_money": null,
  "on_by_default": null,
  "ordinal": null,
  "modifier_list_id": null,
  "v2_id": null
}
```

