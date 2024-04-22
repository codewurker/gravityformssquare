<?php

declare(strict_types=1);

namespace Square\Models;

class BatchChangeInventoryRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var InventoryChange[]|null
     */
    private $changes;

    /**
     * @var bool|null
     */
    private $ignoreUnchangedCounts;

    /**
     * Returns Idempotency Key.
     *
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/basics/api101/idempotency) in the
     * [API Development 101](https://developer.squareup.com/docs/basics/api101/overview) section for more
     * information.
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     *
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/basics/api101/idempotency) in the
     * [API Development 101](https://developer.squareup.com/docs/basics/api101/overview) section for more
     * information.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Changes.
     *
     * The set of physical counts and inventory adjustments to be made.
     * Changes are applied based on the client-supplied timestamp and may be sent
     * out of order. Max size is 100 changes.
     *
     * @return InventoryChange[]|null
     */
    public function getChanges(): ?array
    {
        return $this->changes;
    }

    /**
     * Sets Changes.
     *
     * The set of physical counts and inventory adjustments to be made.
     * Changes are applied based on the client-supplied timestamp and may be sent
     * out of order. Max size is 100 changes.
     *
     * @maps changes
     *
     * @param InventoryChange[]|null $changes
     */
    public function setChanges(?array $changes): void
    {
        $this->changes = $changes;
    }

    /**
     * Returns Ignore Unchanged Counts.
     *
     * Indicates whether the current physical count should be ignored if
     * the quantity is unchanged since the last physical count. Default: `true`.
     */
    public function getIgnoreUnchangedCounts(): ?bool
    {
        return $this->ignoreUnchangedCounts;
    }

    /**
     * Sets Ignore Unchanged Counts.
     *
     * Indicates whether the current physical count should be ignored if
     * the quantity is unchanged since the last physical count. Default: `true`.
     *
     * @maps ignore_unchanged_counts
     */
    public function setIgnoreUnchangedCounts(?bool $ignoreUnchangedCounts): void
    {
        $this->ignoreUnchangedCounts = $ignoreUnchangedCounts;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['idempotency_key']       = $this->idempotencyKey;
        $json['changes']               = $this->changes;
        $json['ignore_unchanged_counts'] = $this->ignoreUnchangedCounts;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
