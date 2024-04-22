<?php

declare(strict_types=1);

namespace Square\Models;

class CatalogQueryItemsForItemOptions implements \JsonSerializable
{
    /**
     * @var string[]|null
     */
    private $itemOptionIds;

    /**
     * Returns Item Option Ids.
     *
     * A set of `CatalogItemOption` IDs to be used to find associated
     * `CatalogItem`s. All Items that contain all of the given Item Options (in any order)
     * will be returned.
     *
     * @return string[]|null
     */
    public function getItemOptionIds(): ?array
    {
        return $this->itemOptionIds;
    }

    /**
     * Sets Item Option Ids.
     *
     * A set of `CatalogItemOption` IDs to be used to find associated
     * `CatalogItem`s. All Items that contain all of the given Item Options (in any order)
     * will be returned.
     *
     * @maps item_option_ids
     *
     * @param string[]|null $itemOptionIds
     */
    public function setItemOptionIds(?array $itemOptionIds): void
    {
        $this->itemOptionIds = $itemOptionIds;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['item_option_ids'] = $this->itemOptionIds;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
