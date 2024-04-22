## Catalog Discount

A discount in the Catalog object model.

### Structure

`CatalogDiscount`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `name` | `?string` | Optional | The discount name. Searchable. This field has max length of 255 Unicode code points. |
| `discountType` | [`?string (CatalogDiscountType)`](/doc/models/catalog-discount-type.md) | Optional | How to apply a CatalogDiscount to a CatalogItem. |
| `percentage` | `?string` | Optional | The percentage of the discount as a string representation of a decimal number, using a `.` as the decimal<br>separator and without a `%` sign. A value of `7.5` corresponds to `7.5%`. Specify a percentage of `0` if `discount_type`<br>is `VARIABLE_PERCENTAGE`.<br><br>Do not include this field for amount-based or variable discounts. |
| `amountMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |
| `pinRequired` | `?bool` | Optional | Indicates whether a mobile staff member needs to enter their PIN to apply the<br>discount to a payment in the Square Point of Sale app. |
| `labelColor` | `?string` | Optional | The color of the discount display label in the Square Point of Sale app. This must be a valid hex color code. |
| `modifyTaxBasis` | [`?string (CatalogDiscountModifyTaxBasis)`](/doc/models/catalog-discount-modify-tax-basis.md) | Optional | -  |

### Example (as JSON)

```json
{
  "object": {
    "type": "DISCOUNT",
    "id": "#Maythe4th",
    "present_at_all_locations": true,
    "discount_data": {
      "name": "Welcome to the Dark(Roast) Side!",
      "discount_type": "FIXED_PERCENTAGE",
      "percentage": "5.4",
      "pin_required": false,
      "label_color": "red"
    }
  }
}
```

