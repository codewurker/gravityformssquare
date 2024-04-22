## Cash Drawer Shift Summary

The summary of a closed cash drawer shift.
This model contains only the money counted to start a cash drawer shift, counted
at the end of the shift, and the amount that should be in the drawer at shift
end based on summing all cash drawer shift events.

### Structure

`CashDrawerShiftSummary`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `?string` | Optional | The shift unique ID. |
| `state` | [`?string (CashDrawerShiftState)`](/doc/models/cash-drawer-shift-state.md) | Optional | The current state of a cash drawer shift. |
| `openedAt` | `?string` | Optional | The shift start time in ISO 8601 format. |
| `endedAt` | `?string` | Optional | The shift end time in ISO 8601 format. |
| `closedAt` | `?string` | Optional | The shift close time in ISO 8601 format. |
| `description` | `?string` | Optional | An employee free-text description of a cash drawer shift. |
| `openedCashMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |
| `expectedCashMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |
| `closedCashMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. |

### Example (as JSON)

```json
{
  "id": null,
  "state": null,
  "opened_at": null,
  "ended_at": null,
  "closed_at": null,
  "description": null,
  "opened_cash_money": null,
  "expected_cash_money": null,
  "closed_cash_money": null
}
```

