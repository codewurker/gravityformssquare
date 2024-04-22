<?php

declare(strict_types=1);

namespace Square\Models;

class CatalogInfoResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogInfoResponseLimits|null
     */
    private $limits;

    /**
     * @var StandardUnitDescriptionGroup|null
     */
    private $standardUnitDescriptionGroup;

    /**
     * Returns Errors.
     *
     * The set of errors encountered.
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
     * The set of errors encountered.
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
     * Returns Limits.
     */
    public function getLimits(): ?CatalogInfoResponseLimits
    {
        return $this->limits;
    }

    /**
     * Sets Limits.
     *
     * @maps limits
     */
    public function setLimits(?CatalogInfoResponseLimits $limits): void
    {
        $this->limits = $limits;
    }

    /**
     * Returns Standard Unit Description Group.
     *
     * Group of standard measurement units.
     */
    public function getStandardUnitDescriptionGroup(): ?StandardUnitDescriptionGroup
    {
        return $this->standardUnitDescriptionGroup;
    }

    /**
     * Sets Standard Unit Description Group.
     *
     * Group of standard measurement units.
     *
     * @maps standard_unit_description_group
     */
    public function setStandardUnitDescriptionGroup(?StandardUnitDescriptionGroup $standardUnitDescriptionGroup): void
    {
        $this->standardUnitDescriptionGroup = $standardUnitDescriptionGroup;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors']                       = $this->errors;
        $json['limits']                       = $this->limits;
        $json['standard_unit_description_group'] = $this->standardUnitDescriptionGroup;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
