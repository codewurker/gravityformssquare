<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a group of customer profiles.
 *
 * Customer groups can be created, modified, and have their membership defined either via
 * the Customers API or within Customer Directory in the Square Dashboard or Point of Sale.
 */
class CustomerGroup implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns Id.
     *
     * Unique Square-generated ID for the customer group.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * Unique Square-generated ID for the customer group.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Name.
     *
     * Name of the customer group.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * Name of the customer group.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Created At.
     *
     * The timestamp when the customer group was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * The timestamp when the customer group was created, in RFC 3339 format.
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
     * The timesamp when the customer group was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     *
     * The timesamp when the customer group was last updated, in RFC 3339 format.
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
        $json['id']        = $this->id;
        $json['name']      = $this->name;
        $json['created_at'] = $this->createdAt;
        $json['updated_at'] = $this->updatedAt;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
