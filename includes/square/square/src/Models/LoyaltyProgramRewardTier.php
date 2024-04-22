<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Describes a loyalty program reward tier.
 */
class LoyaltyProgramRewardTier implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $points;

    /**
     * @var string
     */
    private $name;

    /**
     * @var LoyaltyProgramRewardDefinition
     */
    private $definition;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @param string $id
     * @param int $points
     * @param string $name
     * @param LoyaltyProgramRewardDefinition $definition
     * @param string $createdAt
     */
    public function __construct(
        string $id,
        int $points,
        string $name,
        LoyaltyProgramRewardDefinition $definition,
        string $createdAt
    ) {
        $this->id = $id;
        $this->points = $points;
        $this->name = $name;
        $this->definition = $definition;
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Id.
     *
     * The Square-assigned ID of the reward tier.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * The Square-assigned ID of the reward tier.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Points.
     *
     * The points exchanged for the reward tier.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     *
     * The points exchanged for the reward tier.
     *
     * @required
     * @maps points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Name.
     *
     * The name of the reward tier.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * The name of the reward tier.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Definition.
     *
     * Provides details about the loyalty program reward tier definition.
     */
    public function getDefinition(): LoyaltyProgramRewardDefinition
    {
        return $this->definition;
    }

    /**
     * Sets Definition.
     *
     * Provides details about the loyalty program reward tier definition.
     *
     * @required
     * @maps definition
     */
    public function setDefinition(LoyaltyProgramRewardDefinition $definition): void
    {
        $this->definition = $definition;
    }

    /**
     * Returns Created At.
     *
     * The timestamp when the reward tier was created, in RFC 3339 format.
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * The timestamp when the reward tier was created, in RFC 3339 format.
     *
     * @required
     * @maps created_at
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
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
        $json['points']     = $this->points;
        $json['name']       = $this->name;
        $json['definition'] = $this->definition;
        $json['created_at'] = $this->createdAt;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
