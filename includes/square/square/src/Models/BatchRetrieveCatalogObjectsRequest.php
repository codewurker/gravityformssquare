<?php

declare(strict_types=1);

namespace Square\Models;

class BatchRetrieveCatalogObjectsRequest implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $objectIds;

    /**
     * @var bool|null
     */
    private $includeRelatedObjects;

    /**
     * @param string[] $objectIds
     */
    public function __construct(array $objectIds)
    {
        $this->objectIds = $objectIds;
    }

    /**
     * Returns Object Ids.
     *
     * The IDs of the CatalogObjects to be retrieved.
     *
     * @return string[]
     */
    public function getObjectIds(): array
    {
        return $this->objectIds;
    }

    /**
     * Sets Object Ids.
     *
     * The IDs of the CatalogObjects to be retrieved.
     *
     * @required
     * @maps object_ids
     *
     * @param string[] $objectIds
     */
    public function setObjectIds(array $objectIds): void
    {
        $this->objectIds = $objectIds;
    }

    /**
     * Returns Include Related Objects.
     *
     * If `true`, the response will include additional objects that are related to the
     * requested objects, as follows:
     *
     * If the `objects` field of the response contains a CatalogItem, its associated
     * CatalogCategory objects, CatalogTax objects, CatalogImage objects and
     * CatalogModifierLists will be returned in the `related_objects` field of the
     * response. If the `objects` field of the response contains a CatalogItemVariation,
     * its parent CatalogItem will be returned in the `related_objects` field of
     * the response.
     */
    public function getIncludeRelatedObjects(): ?bool
    {
        return $this->includeRelatedObjects;
    }

    /**
     * Sets Include Related Objects.
     *
     * If `true`, the response will include additional objects that are related to the
     * requested objects, as follows:
     *
     * If the `objects` field of the response contains a CatalogItem, its associated
     * CatalogCategory objects, CatalogTax objects, CatalogImage objects and
     * CatalogModifierLists will be returned in the `related_objects` field of the
     * response. If the `objects` field of the response contains a CatalogItemVariation,
     * its parent CatalogItem will be returned in the `related_objects` field of
     * the response.
     *
     * @maps include_related_objects
     */
    public function setIncludeRelatedObjects(?bool $includeRelatedObjects): void
    {
        $this->includeRelatedObjects = $includeRelatedObjects;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['object_ids']            = $this->objectIds;
        $json['include_related_objects'] = $this->includeRelatedObjects;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
