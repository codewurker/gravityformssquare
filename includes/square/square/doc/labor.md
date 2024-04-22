# Labor

```php
$laborApi = $client->getLaborApi();
```

## Class Name

`LaborApi`

## Methods

* [List Break Types](/doc/labor.md#list-break-types)
* [Create Break Type](/doc/labor.md#create-break-type)
* [Delete Break Type](/doc/labor.md#delete-break-type)
* [Get Break Type](/doc/labor.md#get-break-type)
* [Update Break Type](/doc/labor.md#update-break-type)
* [List Employee Wages](/doc/labor.md#list-employee-wages)
* [Get Employee Wage](/doc/labor.md#get-employee-wage)
* [Create Shift](/doc/labor.md#create-shift)
* [Search Shifts](/doc/labor.md#search-shifts)
* [Delete Shift](/doc/labor.md#delete-shift)
* [Get Shift](/doc/labor.md#get-shift)
* [Update Shift](/doc/labor.md#update-shift)
* [List Workweek Configs](/doc/labor.md#list-workweek-configs)
* [Update Workweek Config](/doc/labor.md#update-workweek-config)

## List Break Types

Returns a paginated list of `BreakType` instances for a business.

```php
function listBreakTypes(?string $locationId = null, ?int $limit = null, ?string $cursor = null): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `?string` | Query, Optional | Filter Break Types returned to only those that are associated with the<br>specified location. |
| `limit` | `?int` | Query, Optional | Maximum number of Break Types to return per page. Can range between 1<br>and 200. The default is the maximum at 200. |
| `cursor` | `?string` | Query, Optional | Pointer to the next page of Break Type results to fetch. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`ListBreakTypesResponse`](/doc/models/list-break-types-response.md).

### Example Usage

```php
$apiResponse = $laborApi->listBreakTypes();

if ($apiResponse->isSuccess()) {
    $listBreakTypesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Create Break Type

Creates a new `BreakType`.

A `BreakType` is a template for creating `Break` objects.
You must provide the following values in your request to this
endpoint:

- `location_id`
- `break_name`
- `expected_duration`
- `is_paid`

You can only have 3 `BreakType` instances per location. If you attempt to add a 4th
`BreakType` for a location, an `INVALID_REQUEST_ERROR` "Exceeded limit of 3 breaks per location."
is returned.

```php
function createBreakType(CreateBreakTypeRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateBreakTypeRequest`](/doc/models/create-break-type-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`CreateBreakTypeResponse`](/doc/models/create-break-type-response.md).

### Example Usage

```php
$body_breakType_locationId = 'CGJN03P1D08GF';
$body_breakType_breakName = 'Lunch Break';
$body_breakType_expectedDuration = 'PT30M';
$body_breakType_isPaid = true;
$body_breakType = new Models\BreakType(
    $body_breakType_locationId,
    $body_breakType_breakName,
    $body_breakType_expectedDuration,
    $body_breakType_isPaid
);
$body = new Models\CreateBreakTypeRequest(
    $body_breakType
);
$body->setIdempotencyKey('PAD3NG5KSN2GL');

$apiResponse = $laborApi->createBreakType($body);

if ($apiResponse->isSuccess()) {
    $createBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Delete Break Type

Deletes an existing `BreakType`.

A `BreakType` can be deleted even if it is referenced from a `Shift`.

```php
function deleteBreakType(string $id): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `BreakType` being deleted. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`DeleteBreakTypeResponse`](/doc/models/delete-break-type-response.md).

### Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->deleteBreakType($id);

if ($apiResponse->isSuccess()) {
    $deleteBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Get Break Type

Returns a single `BreakType` specified by id.

```php
function getBreakType(string $id): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `BreakType` being retrieved. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`GetBreakTypeResponse`](/doc/models/get-break-type-response.md).

### Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getBreakType($id);

if ($apiResponse->isSuccess()) {
    $getBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Update Break Type

Updates an existing `BreakType`.

```php
function updateBreakType(string $id, UpdateBreakTypeRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `BreakType` being updated. |
| `body` | [`UpdateBreakTypeRequest`](/doc/models/update-break-type-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`UpdateBreakTypeResponse`](/doc/models/update-break-type-response.md).

### Example Usage

```php
$id = 'id0';
$body_breakType_locationId = '26M7H24AZ9N6R';
$body_breakType_breakName = 'Lunch';
$body_breakType_expectedDuration = 'PT50M';
$body_breakType_isPaid = true;
$body_breakType = new Models\BreakType(
    $body_breakType_locationId,
    $body_breakType_breakName,
    $body_breakType_expectedDuration,
    $body_breakType_isPaid
);
$body_breakType->setVersion(1);
$body = new Models\UpdateBreakTypeRequest(
    $body_breakType
);

$apiResponse = $laborApi->updateBreakType($id, $body);

if ($apiResponse->isSuccess()) {
    $updateBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## List Employee Wages

Returns a paginated list of `EmployeeWage` instances for a business.

```php
function listEmployeeWages(?string $employeeId = null, ?int $limit = null, ?string $cursor = null): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `employeeId` | `?string` | Query, Optional | Filter wages returned to only those that are associated with the<br>specified employee. |
| `limit` | `?int` | Query, Optional | Maximum number of Employee Wages to return per page. Can range between<br>1 and 200. The default is the maximum at 200. |
| `cursor` | `?string` | Query, Optional | Pointer to the next page of Employee Wage results to fetch. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`ListEmployeeWagesResponse`](/doc/models/list-employee-wages-response.md).

### Example Usage

```php
$apiResponse = $laborApi->listEmployeeWages();

if ($apiResponse->isSuccess()) {
    $listEmployeeWagesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Get Employee Wage

Returns a single `EmployeeWage` specified by id.

```php
function getEmployeeWage(string $id): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `EmployeeWage` being retrieved. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`GetEmployeeWageResponse`](/doc/models/get-employee-wage-response.md).

### Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getEmployeeWage($id);

if ($apiResponse->isSuccess()) {
    $getEmployeeWageResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Create Shift

Creates a new `Shift`.

A `Shift` represents a complete work day for a single employee.
You must provide the following values in your request to this
endpoint:

- `location_id`
- `employee_id`
- `start_at`

An attempt to create a new `Shift` can result in a `BAD_REQUEST` error when:

- The `status` of the new `Shift` is `OPEN` and the employee has another
  shift with an `OPEN` status.
- The `start_at` date is in the future
- the `start_at` or `end_at` overlaps another shift for the same employee
- If `Break`s are set in the request, a break `start_at`
  must not be before the `Shift.start_at`. A break `end_at` must not be after
  the `Shift.end_at`

```php
function createShift(CreateShiftRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateShiftRequest`](/doc/models/create-shift-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`CreateShiftResponse`](/doc/models/create-shift-response.md).

### Example Usage

```php
$body_shift_employeeId = 'ormj0jJJZ5OZIzxrZYJI';
$body_shift_startAt = '2019-01-25T03:11:00-05:00';
$body_shift = new Models\Shift(
    $body_shift_employeeId,
    $body_shift_startAt
);
$body_shift->setLocationId('PAA1RJZZKXBFG');
$body_shift->setEndAt('2019-01-25T13:11:00-05:00');
$body_shift->setWage(new Models\ShiftWage);
$body_shift->getWage()->setTitle('Barista');
$body_shift->getWage()->setHourlyRate(new Models\Money);
$body_shift->getWage()->getHourlyRate()->setAmount(1100);
$body_shift->getWage()->getHourlyRate()->setCurrency(Models\Currency::USD);
$body_shift_breaks = [];

$body_shift_breaks_0_startAt = '2019-01-25T06:11:00-05:00';
$body_shift_breaks_0_breakTypeId = 'REGS1EQR1TPZ5';
$body_shift_breaks_0_name = 'Tea Break';
$body_shift_breaks_0_expectedDuration = 'PT5M';
$body_shift_breaks_0_isPaid = true;
$body_shift_breaks[0] = new Models\MBreak(
    $body_shift_breaks_0_startAt,
    $body_shift_breaks_0_breakTypeId,
    $body_shift_breaks_0_name,
    $body_shift_breaks_0_expectedDuration,
    $body_shift_breaks_0_isPaid
);
$body_shift_breaks[0]->setEndAt('2019-01-25T06:16:00-05:00');
$body_shift->setBreaks($body_shift_breaks);

$body = new Models\CreateShiftRequest(
    $body_shift
);
$body->setIdempotencyKey('HIDSNG5KS478L');

$apiResponse = $laborApi->createShift($body);

if ($apiResponse->isSuccess()) {
    $createShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Search Shifts

Returns a paginated list of `Shift` records for a business.
The list to be returned can be filtered by:

- Location IDs **and**
- employee IDs **and**
- shift status (`OPEN`, `CLOSED`) **and**
- shift start **and**
- shift end **and**
- work day details

The list can be sorted by:

- `start_at`
- `end_at`
- `created_at`
- `updated_at`

```php
function searchShifts(SearchShiftsRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchShiftsRequest`](/doc/models/search-shifts-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`SearchShiftsResponse`](/doc/models/search-shifts-response.md).

### Example Usage

```php
$body = new Models\SearchShiftsRequest;
$body->setQuery(new Models\ShiftQuery);
$body->getQuery()->setFilter(new Models\ShiftFilter);
$body->getQuery()->getFilter()->setWorkday(new Models\ShiftWorkday);
$body->getQuery()->getFilter()->getWorkday()->setDateRange(new Models\DateRange);
$body->getQuery()->getFilter()->getWorkday()->getDateRange()->setStartDate('2019-01-20');
$body->getQuery()->getFilter()->getWorkday()->getDateRange()->setEndDate('2019-02-03');
$body->getQuery()->getFilter()->getWorkday()->setMatchShiftsBy(Models\ShiftWorkdayMatcher::START_AT);
$body->getQuery()->getFilter()->getWorkday()->setDefaultTimezone('America/Los_Angeles');
$body->setLimit(100);

$apiResponse = $laborApi->searchShifts($body);

if ($apiResponse->isSuccess()) {
    $searchShiftsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Delete Shift

Deletes a `Shift`.

```php
function deleteShift(string $id): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `Shift` being deleted. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`DeleteShiftResponse`](/doc/models/delete-shift-response.md).

### Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->deleteShift($id);

if ($apiResponse->isSuccess()) {
    $deleteShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Get Shift

Returns a single `Shift` specified by id.

```php
function getShift(string $id): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `Shift` being retrieved. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`GetShiftResponse`](/doc/models/get-shift-response.md).

### Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getShift($id);

if ($apiResponse->isSuccess()) {
    $getShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Update Shift

Updates an existing `Shift`.

When adding a `Break` to a `Shift`, any earlier `Breaks` in the `Shift` have
the `end_at` property set to a valid RFC-3339 datetime string.

When closing a `Shift`, all `Break` instances in the shift must be complete with `end_at`
set on each `Break`.

```php
function updateShift(string $id, UpdateShiftRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | ID of the object being updated. |
| `body` | [`UpdateShiftRequest`](/doc/models/update-shift-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`UpdateShiftResponse`](/doc/models/update-shift-response.md).

### Example Usage

```php
$id = 'id0';
$body_shift_employeeId = 'ormj0jJJZ5OZIzxrZYJI';
$body_shift_startAt = '2019-01-25T03:11:00-05:00';
$body_shift = new Models\Shift(
    $body_shift_employeeId,
    $body_shift_startAt
);
$body_shift->setLocationId('PAA1RJZZKXBFG');
$body_shift->setEndAt('2019-01-25T13:11:00-05:00');
$body_shift->setWage(new Models\ShiftWage);
$body_shift->getWage()->setTitle('Bartender');
$body_shift->getWage()->setHourlyRate(new Models\Money);
$body_shift->getWage()->getHourlyRate()->setAmount(1500);
$body_shift->getWage()->getHourlyRate()->setCurrency(Models\Currency::USD);
$body_shift_breaks = [];

$body_shift_breaks_0_startAt = '2019-01-25T06:11:00-05:00';
$body_shift_breaks_0_breakTypeId = 'REGS1EQR1TPZ5';
$body_shift_breaks_0_name = 'Tea Break';
$body_shift_breaks_0_expectedDuration = 'PT5M';
$body_shift_breaks_0_isPaid = true;
$body_shift_breaks[0] = new Models\MBreak(
    $body_shift_breaks_0_startAt,
    $body_shift_breaks_0_breakTypeId,
    $body_shift_breaks_0_name,
    $body_shift_breaks_0_expectedDuration,
    $body_shift_breaks_0_isPaid
);
$body_shift_breaks[0]->setId('X7GAQYVVRRG6P');
$body_shift_breaks[0]->setEndAt('2019-01-25T06:16:00-05:00');
$body_shift->setBreaks($body_shift_breaks);

$body_shift->setVersion(1);
$body = new Models\UpdateShiftRequest(
    $body_shift
);

$apiResponse = $laborApi->updateShift($id, $body);

if ($apiResponse->isSuccess()) {
    $updateShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## List Workweek Configs

Returns a list of `WorkweekConfig` instances for a business.

```php
function listWorkweekConfigs(?int $limit = null, ?string $cursor = null): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `limit` | `?int` | Query, Optional | Maximum number of Workweek Configs to return per page. |
| `cursor` | `?string` | Query, Optional | Pointer to the next page of Workweek Config results to fetch. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`ListWorkweekConfigsResponse`](/doc/models/list-workweek-configs-response.md).

### Example Usage

```php
$apiResponse = $laborApi->listWorkweekConfigs();

if ($apiResponse->isSuccess()) {
    $listWorkweekConfigsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

## Update Workweek Config

Updates a `WorkweekConfig`.

```php
function updateWorkweekConfig(string $id, UpdateWorkweekConfigRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the `WorkweekConfig` object being updated. |
| `body` | [`UpdateWorkweekConfigRequest`](/doc/models/update-workweek-config-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`UpdateWorkweekConfigResponse`](/doc/models/update-workweek-config-response.md).

### Example Usage

```php
$id = 'id0';
$body_workweekConfig_startOfWeek = Models\Weekday::MON;
$body_workweekConfig_startOfDayLocalTime = '10:00';
$body_workweekConfig = new Models\WorkweekConfig(
    $body_workweekConfig_startOfWeek,
    $body_workweekConfig_startOfDayLocalTime
);
$body_workweekConfig->setVersion(10);
$body = new Models\UpdateWorkweekConfigRequest(
    $body_workweekConfig
);

$apiResponse = $laborApi->updateWorkweekConfig($id, $body);

if ($apiResponse->isSuccess()) {
    $updateWorkweekConfigResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

