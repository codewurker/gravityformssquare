<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A record of the hourly rate, start, and end times for a single work shift
 * for an employee. May include a record of the start and end times for breaks
 * taken during the shift.
 */
class Shift implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $employeeId;

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var string|null
     */
    private $timezone;

    /**
     * @var string
     */
    private $startAt;

    /**
     * @var string|null
     */
    private $endAt;

    /**
     * @var ShiftWage|null
     */
    private $wage;

    /**
     * @var MBreak[]|null
     */
    private $breaks;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @param string $employeeId
     * @param string $startAt
     */
    public function __construct(string $employeeId, string $startAt)
    {
        $this->employeeId = $employeeId;
        $this->startAt = $startAt;
    }

    /**
     * Returns Id.
     *
     * UUID for this object
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * UUID for this object
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Employee Id.
     *
     * The ID of the employee this shift belongs to.
     */
    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    /**
     * Sets Employee Id.
     *
     * The ID of the employee this shift belongs to.
     *
     * @required
     * @maps employee_id
     */
    public function setEmployeeId(string $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    /**
     * Returns Location Id.
     *
     * The ID of the location this shift occurred at. Should be based on
     * where the employee clocked in.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     *
     * The ID of the location this shift occurred at. Should be based on
     * where the employee clocked in.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Timezone.
     *
     * Read-only convenience value that is calculated from the location based
     * on `location_id`. Format: the IANA Timezone Database identifier for the
     * location timezone.
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * Sets Timezone.
     *
     * Read-only convenience value that is calculated from the location based
     * on `location_id`. Format: the IANA Timezone Database identifier for the
     * location timezone.
     *
     * @maps timezone
     */
    public function setTimezone(?string $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * Returns Start At.
     *
     * RFC 3339; shifted to location timezone + offset. Precision up to the
     * minute is respected; seconds are truncated.
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * Sets Start At.
     *
     * RFC 3339; shifted to location timezone + offset. Precision up to the
     * minute is respected; seconds are truncated.
     *
     * @required
     * @maps start_at
     */
    public function setStartAt(string $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * Returns End At.
     *
     * RFC 3339; shifted to timezone + offset. Precision up to the minute is
     * respected; seconds are truncated. The `end_at` minute is not
     * counted when the shift length is calculated. For example, a shift from `00:00`
     * to `08:01` is considered an 8 hour shift (midnight to 8am).
     */
    public function getEndAt(): ?string
    {
        return $this->endAt;
    }

    /**
     * Sets End At.
     *
     * RFC 3339; shifted to timezone + offset. Precision up to the minute is
     * respected; seconds are truncated. The `end_at` minute is not
     * counted when the shift length is calculated. For example, a shift from `00:00`
     * to `08:01` is considered an 8 hour shift (midnight to 8am).
     *
     * @maps end_at
     */
    public function setEndAt(?string $endAt): void
    {
        $this->endAt = $endAt;
    }

    /**
     * Returns Wage.
     *
     * The hourly wage rate used to compensate an employee for this shift.
     */
    public function getWage(): ?ShiftWage
    {
        return $this->wage;
    }

    /**
     * Sets Wage.
     *
     * The hourly wage rate used to compensate an employee for this shift.
     *
     * @maps wage
     */
    public function setWage(?ShiftWage $wage): void
    {
        $this->wage = $wage;
    }

    /**
     * Returns Breaks.
     *
     * A list of any paid or unpaid breaks that were taken during this shift.
     *
     * @return MBreak[]|null
     */
    public function getBreaks(): ?array
    {
        return $this->breaks;
    }

    /**
     * Sets Breaks.
     *
     * A list of any paid or unpaid breaks that were taken during this shift.
     *
     * @maps breaks
     *
     * @param MBreak[]|null $breaks
     */
    public function setBreaks(?array $breaks): void
    {
        $this->breaks = $breaks;
    }

    /**
     * Returns Status.
     *
     * Enumerates the possible status of a `Shift`
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     *
     * Enumerates the possible status of a `Shift`
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Version.
     *
     * Used for resolving concurrency issues; request will fail if version
     * provided does not match server version at time of request. If not provided,
     * Square executes a blind write; potentially overwriting data from another
     * write.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     *
     * Used for resolving concurrency issues; request will fail if version
     * provided does not match server version at time of request. If not provided,
     * Square executes a blind write; potentially overwriting data from another
     * write.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Created At.
     *
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     *
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     *
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']         = $this->id;
        $json['employee_id'] = $this->employeeId;
        $json['location_id'] = $this->locationId;
        $json['timezone']   = $this->timezone;
        $json['start_at']   = $this->startAt;
        $json['end_at']     = $this->endAt;
        $json['wage']       = $this->wage;
        $json['breaks']     = $this->breaks;
        $json['status']     = $this->status;
        $json['version']    = $this->version;
        $json['created_at'] = $this->createdAt;
        $json['updated_at'] = $this->updatedAt;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
