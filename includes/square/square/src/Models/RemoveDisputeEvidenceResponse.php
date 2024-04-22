<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines fields in a RemoveDisputeEvidence response.
 */
class RemoveDisputeEvidenceResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Errors.
     *
     * Information on errors encountered during the request.
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
     * Information on errors encountered during the request.
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
        $json['errors'] = $this->errors;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
