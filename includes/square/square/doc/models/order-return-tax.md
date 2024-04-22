## Order Return Tax

Represents a tax being returned that applies to one or more return line items in an order.

Fixed-amount, order-scoped taxes are distributed across all non-zero return line item totals.
The amount distributed to each return line item is relative to that item’s contribution to the
order subtotal.

### Structure

`OrderReturnTax`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `uid` | `?string` | Optional | Unique ID that identifies the return tax only within this order. |
| `sourceTaxUid` | `?string` | Optional | `uid` of the Tax from the Order which contains the original charge of this tax. |
| `catalogObjectId` | `?string` | Optional | The catalog object id referencing [CatalogTax](#type-catalogtax). |
| `name` | `?string` | Optional | The tax's name. |
| `type` | [`?string (OrderLineItemTaxType)`](/doc/models/order-line-item-tax-type.md) | Optional | Indicates how the tax is applied to the associated line item or order. |
| `percentage` | `?string` | Optional | The percentage of the tax, as a string representation of a decimal number.<br>For example, a value of `"7.25"` corresponds to a percentage of 7.25%. |
| `appliedMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |
| `scope` | [`?string (OrderLineItemTaxScope)`](/doc/models/order-line-item-tax-scope.md) | Optional | Indicates whether this is a line item or order level tax. |

### Example (as JSON)

```json
{
  "uid": null,
  "source_tax_uid": null,
  "catalog_object_id": null,
  "name": null,
  "type": null,
  "percentage": null,
  "applied_money": null,
  "scope": null
}
```

