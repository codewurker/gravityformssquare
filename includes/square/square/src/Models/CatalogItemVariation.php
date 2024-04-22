<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * An item variation (i.e., product) in the Catalog object model. Each item
 * may have a maximum of 250 item variations.
 */
class CatalogItemVariation implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $itemId;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $sku;

    /**
     * @var string|null
     */
    private $upc;

    /**
     * @var int|null
     */
    private $ordinal;

    /**
     * @var string|null
     */
    private $pricingType;

    /**
     * @var Money|null
     */
    private $priceMoney;

    /**
     * @var ItemVariationLocationOverrides[]|null
     */
    private $locationOverrides;

    /**
     * @var bool|null
     */
    private $trackInventory;

    /**
     * @var string|null
     */
    private $inventoryAlertType;

    /**
     * @var int|null
     */
    private $inventoryAlertThreshold;

    /**
     * @var string|null
     */
    private $userData;

    /**
     * @var int|null
     */
    private $serviceDuration;

    /**
     * @var CatalogItemOptionValueForItemVariation[]|null
     */
    private $itemOptionValues;

    /**
     * @var string|null
     */
    private $measurementUnitId;

    /**
     * Returns Item Id.
     *
     * The ID of the `CatalogItem` associated with this item variation. Searchable.
     */
    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    /**
     * Sets Item Id.
     *
     * The ID of the `CatalogItem` associated with this item variation. Searchable.
     *
     * @maps item_id
     */
    public function setItemId(?string $itemId): void
    {
        $this->itemId = $itemId;
    }

    /**
     * Returns Name.
     *
     * The item variation's name. Searchable. This field has max length of 255 Unicode code points.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * The item variation's name. Searchable. This field has max length of 255 Unicode code points.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Sku.
     *
     * The item variation's SKU, if any. Searchable.
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * Sets Sku.
     *
     * The item variation's SKU, if any. Searchable.
     *
     * @maps sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * Returns Upc.
     *
     * The item variation's UPC, if any. Searchable in the Connect API.
     * This field is only exposed in the Connect API. It is not exposed in Square's Dashboard,
     * Square Point of Sale app or Retail Point of Sale app.
     */
    public function getUpc(): ?string
    {
        return $this->upc;
    }

    /**
     * Sets Upc.
     *
     * The item variation's UPC, if any. Searchable in the Connect API.
     * This field is only exposed in the Connect API. It is not exposed in Square's Dashboard,
     * Square Point of Sale app or Retail Point of Sale app.
     *
     * @maps upc
     */
    public function setUpc(?string $upc): void
    {
        $this->upc = $upc;
    }

    /**
     * Returns Ordinal.
     *
     * The order in which this item variation should be displayed. This value is read-only. On writes, the
     * ordinal
     * for each item variation within a parent `CatalogItem` is set according to the item variations's
     * position. On reads, the value is not guaranteed to be sequential or unique.
     */
    public function getOrdinal(): ?int
    {
        return $this->ordinal;
    }

    /**
     * Sets Ordinal.
     *
     * The order in which this item variation should be displayed. This value is read-only. On writes, the
     * ordinal
     * for each item variation within a parent `CatalogItem` is set according to the item variations's
     * position. On reads, the value is not guaranteed to be sequential or unique.
     *
     * @maps ordinal
     */
    public function setOrdinal(?int $ordinal): void
    {
        $this->ordinal = $ordinal;
    }

    /**
     * Returns Pricing Type.
     *
     * Indicates whether the price of a CatalogItemVariation should be entered manually at the time of sale.
     */
    public function getPricingType(): ?string
    {
        return $this->pricingType;
    }

    /**
     * Sets Pricing Type.
     *
     * Indicates whether the price of a CatalogItemVariation should be entered manually at the time of sale.
     *
     * @maps pricing_type
     */
    public function setPricingType(?string $pricingType): void
    {
        $this->pricingType = $pricingType;
    }

    /**
     * Returns Price Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getPriceMoney(): ?Money
    {
        return $this->priceMoney;
    }

    /**
     * Sets Price Money.
     *
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps price_money
     */
    public function setPriceMoney(?Money $priceMoney): void
    {
        $this->priceMoney = $priceMoney;
    }

    /**
     * Returns Location Overrides.
     *
     * Per-location price and inventory overrides.
     *
     * @return ItemVariationLocationOverrides[]|null
     */
    public function getLocationOverrides(): ?array
    {
        return $this->locationOverrides;
    }

    /**
     * Sets Location Overrides.
     *
     * Per-location price and inventory overrides.
     *
     * @maps location_overrides
     *
     * @param ItemVariationLocationOverrides[]|null $locationOverrides
     */
    public function setLocationOverrides(?array $locationOverrides): void
    {
        $this->locationOverrides = $locationOverrides;
    }

    /**
     * Returns Track Inventory.
     *
     * If `true`, inventory tracking is active for the variation.
     */
    public function getTrackInventory(): ?bool
    {
        return $this->trackInventory;
    }

    /**
     * Sets Track Inventory.
     *
     * If `true`, inventory tracking is active for the variation.
     *
     * @maps track_inventory
     */
    public function setTrackInventory(?bool $trackInventory): void
    {
        $this->trackInventory = $trackInventory;
    }

    /**
     * Returns Inventory Alert Type.
     *
     * Indicates whether Square should alert the merchant when the inventory quantity of a
     * CatalogItemVariation is low.
     */
    public function getInventoryAlertType(): ?string
    {
        return $this->inventoryAlertType;
    }

    /**
     * Sets Inventory Alert Type.
     *
     * Indicates whether Square should alert the merchant when the inventory quantity of a
     * CatalogItemVariation is low.
     *
     * @maps inventory_alert_type
     */
    public function setInventoryAlertType(?string $inventoryAlertType): void
    {
        $this->inventoryAlertType = $inventoryAlertType;
    }

    /**
     * Returns Inventory Alert Threshold.
     *
     * If the inventory quantity for the variation is less than or equal to this value and
     * `inventory_alert_type`
     * is `LOW_QUANTITY`, the variation displays an alert in the merchant dashboard.
     *
     * This value is always an integer.
     */
    public function getInventoryAlertThreshold(): ?int
    {
        return $this->inventoryAlertThreshold;
    }

    /**
     * Sets Inventory Alert Threshold.
     *
     * If the inventory quantity for the variation is less than or equal to this value and
     * `inventory_alert_type`
     * is `LOW_QUANTITY`, the variation displays an alert in the merchant dashboard.
     *
     * This value is always an integer.
     *
     * @maps inventory_alert_threshold
     */
    public function setInventoryAlertThreshold(?int $inventoryAlertThreshold): void
    {
        $this->inventoryAlertThreshold = $inventoryAlertThreshold;
    }

    /**
     * Returns User Data.
     *
     * Arbitrary user metadata to associate with the item variation. Searchable. This field has max length
     * of 255 Unicode code points.
     */
    public function getUserData(): ?string
    {
        return $this->userData;
    }

    /**
     * Sets User Data.
     *
     * Arbitrary user metadata to associate with the item variation. Searchable. This field has max length
     * of 255 Unicode code points.
     *
     * @maps user_data
     */
    public function setUserData(?string $userData): void
    {
        $this->userData = $userData;
    }

    /**
     * Returns Service Duration.
     *
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, then this is the duration of the service in milliseconds. For
     * example, a 30 minute appointment would have the value `1800000`, which is equal to
     * 30 (minutes) * 60 (seconds per minute) * 1000 (milliseconds per second).
     */
    public function getServiceDuration(): ?int
    {
        return $this->serviceDuration;
    }

    /**
     * Sets Service Duration.
     *
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, then this is the duration of the service in milliseconds. For
     * example, a 30 minute appointment would have the value `1800000`, which is equal to
     * 30 (minutes) * 60 (seconds per minute) * 1000 (milliseconds per second).
     *
     * @maps service_duration
     */
    public function setServiceDuration(?int $serviceDuration): void
    {
        $this->serviceDuration = $serviceDuration;
    }

    /**
     * Returns Item Option Values.
     *
     * List of item option values associated with this item variation. Listed
     * in the same order as the item options of the parent item.
     *
     * @return CatalogItemOptionValueForItemVariation[]|null
     */
    public function getItemOptionValues(): ?array
    {
        return $this->itemOptionValues;
    }

    /**
     * Sets Item Option Values.
     *
     * List of item option values associated with this item variation. Listed
     * in the same order as the item options of the parent item.
     *
     * @maps item_option_values
     *
     * @param CatalogItemOptionValueForItemVariation[]|null $itemOptionValues
     */
    public function setItemOptionValues(?array $itemOptionValues): void
    {
        $this->itemOptionValues = $itemOptionValues;
    }

    /**
     * Returns Measurement Unit Id.
     *
     * ID of the ‘CatalogMeasurementUnit’ that is used to measure the quantity
     * sold of this item variation. If left unset, the item will be sold in
     * whole quantities.
     */
    public function getMeasurementUnitId(): ?string
    {
        return $this->measurementUnitId;
    }

    /**
     * Sets Measurement Unit Id.
     *
     * ID of the ‘CatalogMeasurementUnit’ that is used to measure the quantity
     * sold of this item variation. If left unset, the item will be sold in
     * whole quantities.
     *
     * @maps measurement_unit_id
     */
    public function setMeasurementUnitId(?string $measurementUnitId): void
    {
        $this->measurementUnitId = $measurementUnitId;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['item_id']                 = $this->itemId;
        $json['name']                    = $this->name;
        $json['sku']                     = $this->sku;
        $json['upc']                     = $this->upc;
        $json['ordinal']                 = $this->ordinal;
        $json['pricing_type']            = $this->pricingType;
        $json['price_money']             = $this->priceMoney;
        $json['location_overrides']      = $this->locationOverrides;
        $json['track_inventory']         = $this->trackInventory;
        $json['inventory_alert_type']    = $this->inventoryAlertType;
        $json['inventory_alert_threshold'] = $this->inventoryAlertThreshold;
        $json['user_data']               = $this->userData;
        $json['service_duration']        = $this->serviceDuration;
        $json['item_option_values']      = $this->itemOptionValues;
        $json['measurement_unit_id']     = $this->measurementUnitId;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
