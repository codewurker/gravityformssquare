## V1 Update Timecard Request

### Structure

`V1UpdateTimecardRequest`

### Fields

| Name | Type | Description |
|  --- | --- | --- |
| `body` | [`V1Timecard`](/doc/models/v1-timecard.md) | Represents a timecard for an employee. |

### Example (as JSON)

```json
{
  "body": {
    "id": null,
    "employee_id": "employee_id4",
    "deleted": null,
    "clockin_time": null,
    "clockout_time": null,
    "clockin_location_id": null,
    "clockout_location_id": null,
    "created_at": null,
    "updated_at": null,
    "regular_seconds_worked": null,
    "overtime_seconds_worked": null,
    "doubletime_seconds_worked": null
  }
}
```

