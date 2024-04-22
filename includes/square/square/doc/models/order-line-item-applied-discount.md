## Order Line Item Applied Discount

Represents an applied portion of a discount to a line item in an order.

Order scoped discounts will automatically have applied discounts present for each line item.
Line item scoped discounts must have applied discounts added manually for any applicable line
items. The corresponding applied money will automatically be computed based on participating
line items.

### Structure

`OrderLineItemAppliedDiscount`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `uid` | `?string` | Optional | Unique ID that identifies the applied discount only within this order. |
| `discountUid` | `string` |  | The `uid` of the discount the applied discount represents. Must<br>reference a discount present in the `order.discounts` field.<br><br>This field is immutable. To change which discounts apply to a line item,<br>you must delete the discount and re-add it as a new `OrderLineItemAppliedDiscount`. |
| `appliedMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |

### Example (as JSON)

```json
{
  "uid": null,
  "discount_uid": "discount_uid4",
  "applied_money": null
}
```

