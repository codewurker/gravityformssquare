<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A group of variations for a `CatalogItem`.
 */
class CatalogItemOption implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $displayName;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var bool|null
     */
    private $showColors;

    /**
     * @var CatalogObject[]|null
     */
    private $values;

    /**
     * @var int|null
     */
    private $itemCount;

    /**
     * Returns Name.
     *
     * The item option's display name for the seller. Must be unique across
     * all item options. Searchable.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * The item option's display name for the seller. Must be unique across
     * all item options. Searchable.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Display Name.
     *
     * The item option's display name for the customer. Searchable.
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * Sets Display Name.
     *
     * The item option's display name for the customer. Searchable.
     *
     * @maps display_name
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * Returns Description.
     *
     * The item option's human-readable description. Displayed in the Square
     * Point of Sale app for the seller and in the Online Store or on receipts for
     * the buyer.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets Description.
     *
     * The item option's human-readable description. Displayed in the Square
     * Point of Sale app for the seller and in the Online Store or on receipts for
     * the buyer.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns Show Colors.
     *
     * If true, display colors for entries in `values` when present.
     */
    public function getShowColors(): ?bool
    {
        return $this->showColors;
    }

    /**
     * Sets Show Colors.
     *
     * If true, display colors for entries in `values` when present.
     *
     * @maps show_colors
     */
    public function setShowColors(?bool $showColors): void
    {
        $this->showColors = $showColors;
    }

    /**
     * Returns Values.
     *
     * A list of CatalogObjects containing the
     * `CatalogItemOptionValue`s for this item.
     *
     * @return CatalogObject[]|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * Sets Values.
     *
     * A list of CatalogObjects containing the
     * `CatalogItemOptionValue`s for this item.
     *
     * @maps values
     *
     * @param CatalogObject[]|null $values
     */
    public function setValues(?array $values): void
    {
        $this->values = $values;
    }

    /**
     * Returns Item Count.
     *
     * The number of `CatalogItem`s currently associated
     * with this item option. Present only if the `include_counts` was specified
     * in the request. Any count over 100 will be returned as `100`.
     */
    public function getItemCount(): ?int
    {
        return $this->itemCount;
    }

    /**
     * Sets Item Count.
     *
     * The number of `CatalogItem`s currently associated
     * with this item option. Present only if the `include_counts` was specified
     * in the request. Any count over 100 will be returned as `100`.
     *
     * @maps item_count
     */
    public function setItemCount(?int $itemCount): void
    {
        $this->itemCount = $itemCount;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['name']        = $this->name;
        $json['display_name'] = $this->displayName;
        $json['description'] = $this->description;
        $json['show_colors'] = $this->showColors;
        $json['values']      = $this->values;
        $json['item_count']  = $this->itemCount;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
