## Order Quantity Unit

Contains the measurement unit for a quantity and a precision which
specifies the number of digits after the decimal point for decimal quantities.

### Structure

`OrderQuantityUnit`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `measurementUnit` | [`?MeasurementUnit`](/doc/models/measurement-unit.md) | Optional | Represents a unit of measurement to use with a quantity, such as ounces<br>or inches. Exactly one of the following fields are required: `custom_unit`,<br>`area_unit`, `length_unit`, `volume_unit`, and `weight_unit`. |
| `precision` | `?int` | Optional | For non-integer quantities, represents the number of digits after the decimal point that are<br>recorded for this quantity.<br><br>For example, a precision of 1 allows quantities like `"1.0"` and `"1.1"`, but not `"1.01"`.<br><br>Min: 0. Max: 5. |

### Example (as JSON)

```json
{
  "measurement_unit": null,
  "precision": null
}
```

