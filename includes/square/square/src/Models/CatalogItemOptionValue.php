<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * An enumerated value that can link a
 * `CatalogItemVariation` to an item option as one of
 * its item option values.
 */
class CatalogItemOptionValue implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $itemOptionId;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @var int|null
     */
    private $ordinal;

    /**
     * @var int|null
     */
    private $itemVariationCount;

    /**
     * Returns Item Option Id.
     *
     * Unique ID of the associated item option.
     */
    public function getItemOptionId(): ?string
    {
        return $this->itemOptionId;
    }

    /**
     * Sets Item Option Id.
     *
     * Unique ID of the associated item option.
     *
     * @maps item_option_id
     */
    public function setItemOptionId(?string $itemOptionId): void
    {
        $this->itemOptionId = $itemOptionId;
    }

    /**
     * Returns Name.
     *
     * Name of this item option value. Searchable.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * Name of this item option value. Searchable.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Description.
     *
     * A human-readable description for the option value.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets Description.
     *
     * A human-readable description for the option value.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns Color.
     *
     * The HTML-supported hex color for the item option (e.g., "#ff8d4e85").
     * Only displayed if `show_colors` is enabled on the parent `ItemOption`. When
     * left unset, `color` defaults to white ("#ffffff") when `show_colors` is
     * enabled on the parent `ItemOption`.
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * Sets Color.
     *
     * The HTML-supported hex color for the item option (e.g., "#ff8d4e85").
     * Only displayed if `show_colors` is enabled on the parent `ItemOption`. When
     * left unset, `color` defaults to white ("#ffffff") when `show_colors` is
     * enabled on the parent `ItemOption`.
     *
     * @maps color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * Returns Ordinal.
     *
     * Determines where this option value appears in a list of option values.
     */
    public function getOrdinal(): ?int
    {
        return $this->ordinal;
    }

    /**
     * Sets Ordinal.
     *
     * Determines where this option value appears in a list of option values.
     *
     * @maps ordinal
     */
    public function setOrdinal(?int $ordinal): void
    {
        $this->ordinal = $ordinal;
    }

    /**
     * Returns Item Variation Count.
     *
     * The number of `CatalogItemVariation`s that
     * currently make use of this Item Option value. Present only if `retrieve_counts`
     * was specified on the request used to retrieve the parent Item Option of this
     * value.
     *
     * Maximum: 100 counts.
     */
    public function getItemVariationCount(): ?int
    {
        return $this->itemVariationCount;
    }

    /**
     * Sets Item Variation Count.
     *
     * The number of `CatalogItemVariation`s that
     * currently make use of this Item Option value. Present only if `retrieve_counts`
     * was specified on the request used to retrieve the parent Item Option of this
     * value.
     *
     * Maximum: 100 counts.
     *
     * @maps item_variation_count
     */
    public function setItemVariationCount(?int $itemVariationCount): void
    {
        $this->itemVariationCount = $itemVariationCount;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['item_option_id']     = $this->itemOptionId;
        $json['name']               = $this->name;
        $json['description']        = $this->description;
        $json['color']              = $this->color;
        $json['ordinal']            = $this->ordinal;
        $json['item_variation_count'] = $this->itemVariationCount;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
