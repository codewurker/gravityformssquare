<?php

declare(strict_types=1);

namespace Square\Models;

class BatchRetrieveCatalogObjectsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogObject[]|null
     */
    private $objects;

    /**
     * @var CatalogObject[]|null
     */
    private $relatedObjects;

    /**
     * Returns Errors.
     *
     * The set of [Error](#type-error)s encountered.
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
     * The set of [Error](#type-error)s encountered.
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
     * Returns Objects.
     *
     * A list of [CatalogObject](#type-catalogobject)s returned.
     *
     * @return CatalogObject[]|null
     */
    public function getObjects(): ?array
    {
        return $this->objects;
    }

    /**
     * Sets Objects.
     *
     * A list of [CatalogObject](#type-catalogobject)s returned.
     *
     * @maps objects
     *
     * @param CatalogObject[]|null $objects
     */
    public function setObjects(?array $objects): void
    {
        $this->objects = $objects;
    }

    /**
     * Returns Related Objects.
     *
     * A list of [CatalogObject](#type-catalogobject)s referenced by the object in the `objects` field.
     *
     * @return CatalogObject[]|null
     */
    public function getRelatedObjects(): ?array
    {
        return $this->relatedObjects;
    }

    /**
     * Sets Related Objects.
     *
     * A list of [CatalogObject](#type-catalogobject)s referenced by the object in the `objects` field.
     *
     * @maps related_objects
     *
     * @param CatalogObject[]|null $relatedObjects
     */
    public function setRelatedObjects(?array $relatedObjects): void
    {
        $this->relatedObjects = $relatedObjects;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors']         = $this->errors;
        $json['objects']        = $this->objects;
        $json['related_objects'] = $this->relatedObjects;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
