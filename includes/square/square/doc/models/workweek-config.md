## Workweek Config

Sets the Day of the week and hour of the day that a business starts a
work week. Used for the calculation of overtime pay.

### Structure

`WorkweekConfig`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `?string` | Optional | UUID for this object |
| `startOfWeek` | [`string (Weekday)`](/doc/models/weekday.md) |  | The days of the week. |
| `startOfDayLocalTime` | `string` |  | The local time at which a business week cuts over. Represented as a<br>string in `HH:MM` format (`HH:MM:SS` is also accepted, but seconds are<br>truncated). |
| `version` | `?int` | Optional | Used for resolving concurrency issues; request will fail if version<br>provided does not match server version at time of request. If not provided,<br>Square executes a blind write; potentially overwriting data from another<br>write. |
| `createdAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format; presented in UTC |
| `updatedAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format; presented in UTC |

### Example (as JSON)

```json
{
  "id": null,
  "start_of_week": "MON",
  "start_of_day_local_time": "start_of_day_local_time6",
  "version": null,
  "created_at": null,
  "updated_at": null
}
```

