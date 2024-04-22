## Loyalty Program Accrual Rule

Defines an accrual rule, which is how buyers can earn points.

### Structure

`LoyaltyProgramAccrualRule`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `accrualType` | [`string (LoyaltyProgramAccrualRuleType)`](/doc/models/loyalty-program-accrual-rule-type.md) |  | The type of the accrual rule that defines how buyers can earn points. |
| `points` | `?int` | Optional | The number of points that<br>buyers earn based on the `accrual_type`. |
| `visitMinimumAmountMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |
| `spendAmountMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |
| `catalogObjectId` | `?string` | Optional | The ID of the [catalog object](#type-CatalogObject) to purchase to earn the number of points defined by the<br>rule. This is either an item variation or a category, depending on the type. This is defined on<br>`ITEM_VARIATION` rules and `CATEGORY` rules. |

### Example (as JSON)

```json
{
  "accrual_type": "ITEM_VARIATION",
  "points": null,
  "visit_minimum_amount_money": null,
  "spend_amount_money": null,
  "catalog_object_id": null
}
```

