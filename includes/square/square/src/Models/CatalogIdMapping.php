<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A mapping between a client-supplied temporary ID and a permanent server ID.
 */
class CatalogIdMapping implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $clientObjectId;

    /**
     * @var string|null
     */
    private $objectId;

    /**
     * Returns Client Object Id.
     *
     * The client-supplied, temporary `#`-prefixed ID for a new `CatalogObject`.
     */
    public function getClientObjectId(): ?string
    {
        return $this->clientObjectId;
    }

    /**
     * Sets Client Object Id.
     *
     * The client-supplied, temporary `#`-prefixed ID for a new `CatalogObject`.
     *
     * @maps client_object_id
     */
    public function setClientObjectId(?string $clientObjectId): void
    {
        $this->clientObjectId = $clientObjectId;
    }

    /**
     * Returns Object Id.
     *
     * The permanent ID for the CatalogObject created by the server.
     */
    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    /**
     * Sets Object Id.
     *
     * The permanent ID for the CatalogObject created by the server.
     *
     * @maps object_id
     */
    public function setObjectId(?string $objectId): void
    {
        $this->objectId = $objectId;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['client_object_id'] = $this->clientObjectId;
        $json['object_id']      = $this->objectId;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
