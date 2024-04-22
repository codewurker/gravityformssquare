<?php

declare(strict_types=1);

namespace Square\Models;

class ListEmployeesResponse implements \JsonSerializable
{
    /**
     * @var Employee[]|null
     */
    private $employees;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Employees.
     *
     * List of employees returned from the request.
     *
     * @return Employee[]|null
     */
    public function getEmployees(): ?array
    {
        return $this->employees;
    }

    /**
     * Sets Employees.
     *
     * List of employees returned from the request.
     *
     * @maps employees
     *
     * @param Employee[]|null $employees
     */
    public function setEmployees(?array $employees): void
    {
        $this->employees = $employees;
    }

    /**
     * Returns Cursor.
     *
     * The token to be used to retrieve the next page of results.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     *
     * The token to be used to retrieve the next page of results.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Errors.
     *
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     *
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['employees'] = $this->employees;
        $json['cursor']    = $this->cursor;
        $json['errors']    = $this->errors;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
