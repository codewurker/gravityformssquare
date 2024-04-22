<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Contains information defining a custom attribute. Custom attributes are
 * intended to store additional information about a catalog object or to associate a
 * catalog object with an entity in another system. Do not use custom attributes
 * to store any sensitive information (personally identifiable information, card details, etc.).
 * [Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-
 * attributes)
 */
class CatalogCustomAttributeDefinition implements \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var SourceApplication|null
     */
    private $sourceApplication;

    /**
     * @var string[]
     */
    private $allowedObjectTypes;

    /**
     * @var string|null
     */
    private $sellerVisibility;

    /**
     * @var string|null
     */
    private $appVisibility;

    /**
     * @var CatalogCustomAttributeDefinitionStringConfig|null
     */
    private $stringConfig;

    /**
     * @var CatalogCustomAttributeDefinitionNumberConfig|null
     */
    private $numberConfig;

    /**
     * @var CatalogCustomAttributeDefinitionSelectionConfig|null
     */
    private $selectionConfig;

    /**
     * @var int|null
     */
    private $customAttributeUsageCount;

    /**
     * @var string|null
     */
    private $key;

    /**
     * @param string $type
     * @param string $name
     * @param string[] $allowedObjectTypes
     */
    public function __construct(string $type, string $name, array $allowedObjectTypes)
    {
        $this->type = $type;
        $this->name = $name;
        $this->allowedObjectTypes = $allowedObjectTypes;
    }

    /**
     * Returns Type.
     *
     * Defines the possible types for a custom attribute.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     *
     * Defines the possible types for a custom attribute.
     *
     * @required
     * @maps type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Name.
     *
     * The name of this definition for API and seller-facing UI purposes.
     * The name must be unique within the (merchant, application_id) pair. Required.
     * May not be empty and may not exceed 255 characters. Can be modified after creation.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * The name of this definition for API and seller-facing UI purposes.
     * The name must be unique within the (merchant, application_id) pair. Required.
     * May not be empty and may not exceed 255 characters. Can be modified after creation.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Description.
     *
     * Seller-oriented description of the meaning of this Custom Attribute,
     * any constraints that the seller should observe, etc. May be displayed as a tooltip in Square UIs.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets Description.
     *
     * Seller-oriented description of the meaning of this Custom Attribute,
     * any constraints that the seller should observe, etc. May be displayed as a tooltip in Square UIs.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns Source Application.
     *
     * Provides information about the application used to generate an inventory
     * change.
     */
    public function getSourceApplication(): ?SourceApplication
    {
        return $this->sourceApplication;
    }

    /**
     * Sets Source Application.
     *
     * Provides information about the application used to generate an inventory
     * change.
     *
     * @maps source_application
     */
    public function setSourceApplication(?SourceApplication $sourceApplication): void
    {
        $this->sourceApplication = $sourceApplication;
    }

    /**
     * Returns Allowed Object Types.
     *
     * The set of Catalog Object Types that this Custom Attribute may be applied to.
     * Currently, only `ITEM` and `ITEM_VARIATION` are allowed. At least one type must be included.
     * See [CatalogObjectType](#type-catalogobjecttype) for possible values
     *
     * @return string[]
     */
    public function getAllowedObjectTypes(): array
    {
        return $this->allowedObjectTypes;
    }

    /**
     * Sets Allowed Object Types.
     *
     * The set of Catalog Object Types that this Custom Attribute may be applied to.
     * Currently, only `ITEM` and `ITEM_VARIATION` are allowed. At least one type must be included.
     * See [CatalogObjectType](#type-catalogobjecttype) for possible values
     *
     * @required
     * @maps allowed_object_types
     *
     * @param string[] $allowedObjectTypes
     */
    public function setAllowedObjectTypes(array $allowedObjectTypes): void
    {
        $this->allowedObjectTypes = $allowedObjectTypes;
    }

    /**
     * Returns Seller Visibility.
     *
     * Defines the visibility of a custom attribute to sellers in Square
     * client applications, Square APIs or in Square UIs (including Square Point
     * of Sale applications and Square Dashboard).
     */
    public function getSellerVisibility(): ?string
    {
        return $this->sellerVisibility;
    }

    /**
     * Sets Seller Visibility.
     *
     * Defines the visibility of a custom attribute to sellers in Square
     * client applications, Square APIs or in Square UIs (including Square Point
     * of Sale applications and Square Dashboard).
     *
     * @maps seller_visibility
     */
    public function setSellerVisibility(?string $sellerVisibility): void
    {
        $this->sellerVisibility = $sellerVisibility;
    }

    /**
     * Returns App Visibility.
     *
     * Defines the visibility of a custom attribute to applications other than their
     * creating application.
     */
    public function getAppVisibility(): ?string
    {
        return $this->appVisibility;
    }

    /**
     * Sets App Visibility.
     *
     * Defines the visibility of a custom attribute to applications other than their
     * creating application.
     *
     * @maps app_visibility
     */
    public function setAppVisibility(?string $appVisibility): void
    {
        $this->appVisibility = $appVisibility;
    }

    /**
     * Returns String Config.
     *
     * Configuration associated with Custom Attribute Definitions of type `STRING`.
     */
    public function getStringConfig(): ?CatalogCustomAttributeDefinitionStringConfig
    {
        return $this->stringConfig;
    }

    /**
     * Sets String Config.
     *
     * Configuration associated with Custom Attribute Definitions of type `STRING`.
     *
     * @maps string_config
     */
    public function setStringConfig(?CatalogCustomAttributeDefinitionStringConfig $stringConfig): void
    {
        $this->stringConfig = $stringConfig;
    }

    /**
     * Returns Number Config.
     */
    public function getNumberConfig(): ?CatalogCustomAttributeDefinitionNumberConfig
    {
        return $this->numberConfig;
    }

    /**
     * Sets Number Config.
     *
     * @maps number_config
     */
    public function setNumberConfig(?CatalogCustomAttributeDefinitionNumberConfig $numberConfig): void
    {
        $this->numberConfig = $numberConfig;
    }

    /**
     * Returns Selection Config.
     *
     * Configuration associated with `SELECTION`-type custom attribute definitions.
     */
    public function getSelectionConfig(): ?CatalogCustomAttributeDefinitionSelectionConfig
    {
        return $this->selectionConfig;
    }

    /**
     * Sets Selection Config.
     *
     * Configuration associated with `SELECTION`-type custom attribute definitions.
     *
     * @maps selection_config
     */
    public function setSelectionConfig(?CatalogCustomAttributeDefinitionSelectionConfig $selectionConfig): void
    {
        $this->selectionConfig = $selectionConfig;
    }

    /**
     * Returns Custom Attribute Usage Count.
     *
     * __Read-only.__ The number of custom attributes that reference this
     * custom attribute definition. Set by the server in response to a ListCatalog
     * request with `include_counts` set to `true`.  If the actual count is greater
     * than 100, `custom_attribute_usage_count` will be set to `100`.
     */
    public function getCustomAttributeUsageCount(): ?int
    {
        return $this->customAttributeUsageCount;
    }

    /**
     * Sets Custom Attribute Usage Count.
     *
     * __Read-only.__ The number of custom attributes that reference this
     * custom attribute definition. Set by the server in response to a ListCatalog
     * request with `include_counts` set to `true`.  If the actual count is greater
     * than 100, `custom_attribute_usage_count` will be set to `100`.
     *
     * @maps custom_attribute_usage_count
     */
    public function setCustomAttributeUsageCount(?int $customAttributeUsageCount): void
    {
        $this->customAttributeUsageCount = $customAttributeUsageCount;
    }

    /**
     * Returns Key.
     *
     * The name of the desired custom attribute key that can be used to access
     * the custom attribute value on catalog objects. Cannot be modified after the
     * custom attribute definition has been created.
     * Must be between 1 and 60 characters, and may only contain the characters [a-zA-Z0-9_-].
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Sets Key.
     *
     * The name of the desired custom attribute key that can be used to access
     * the custom attribute value on catalog objects. Cannot be modified after the
     * custom attribute definition has been created.
     * Must be between 1 and 60 characters, and may only contain the characters [a-zA-Z0-9_-].
     *
     * @maps key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['type']                      = $this->type;
        $json['name']                      = $this->name;
        $json['description']               = $this->description;
        $json['source_application']        = $this->sourceApplication;
        $json['allowed_object_types']      = $this->allowedObjectTypes;
        $json['seller_visibility']         = $this->sellerVisibility;
        $json['app_visibility']            = $this->appVisibility;
        $json['string_config']             = $this->stringConfig;
        $json['number_config']             = $this->numberConfig;
        $json['selection_config']          = $this->selectionConfig;
        $json['custom_attribute_usage_count'] = $this->customAttributeUsageCount;
        $json['key']                       = $this->key;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
