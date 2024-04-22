<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * A tax in the Catalog object model.
 */
class CatalogTax implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $calculationPhase;

    /**
     * @var string|null
     */
    private $inclusionType;

    /**
     * @var string|null
     */
    private $percentage;

    /**
     * @var bool|null
     */
    private $appliesToCustomAmounts;

    /**
     * @var bool|null
     */
    private $enabled;

    /**
     * Returns Name.
     *
     * The tax's name. Searchable. This field has max length of 255 Unicode code points.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * The tax's name. Searchable. This field has max length of 255 Unicode code points.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Calculation Phase.
     *
     * When to calculate the taxes due on a cart.
     */
    public function getCalculationPhase(): ?string
    {
        return $this->calculationPhase;
    }

    /**
     * Sets Calculation Phase.
     *
     * When to calculate the taxes due on a cart.
     *
     * @maps calculation_phase
     */
    public function setCalculationPhase(?string $calculationPhase): void
    {
        $this->calculationPhase = $calculationPhase;
    }

    /**
     * Returns Inclusion Type.
     *
     * Whether to the tax amount should be additional to or included in the CatalogItem price.
     */
    public function getInclusionType(): ?string
    {
        return $this->inclusionType;
    }

    /**
     * Sets Inclusion Type.
     *
     * Whether to the tax amount should be additional to or included in the CatalogItem price.
     *
     * @maps inclusion_type
     */
    public function setInclusionType(?string $inclusionType): void
    {
        $this->inclusionType = $inclusionType;
    }

    /**
     * Returns Percentage.
     *
     * The percentage of the tax in decimal form, using a `'.'` as the decimal separator and without a
     * `'%'` sign.
     * A value of `7.5` corresponds to 7.5%.
     */
    public function getPercentage(): ?string
    {
        return $this->percentage;
    }

    /**
     * Sets Percentage.
     *
     * The percentage of the tax in decimal form, using a `'.'` as the decimal separator and without a
     * `'%'` sign.
     * A value of `7.5` corresponds to 7.5%.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage = $percentage;
    }

    /**
     * Returns Applies to Custom Amounts.
     *
     * If `true`, the fee applies to custom amounts entered into the Square Point of Sale
     * app that are not associated with a particular `CatalogItem`.
     */
    public function getAppliesToCustomAmounts(): ?bool
    {
        return $this->appliesToCustomAmounts;
    }

    /**
     * Sets Applies to Custom Amounts.
     *
     * If `true`, the fee applies to custom amounts entered into the Square Point of Sale
     * app that are not associated with a particular `CatalogItem`.
     *
     * @maps applies_to_custom_amounts
     */
    public function setAppliesToCustomAmounts(?bool $appliesToCustomAmounts): void
    {
        $this->appliesToCustomAmounts = $appliesToCustomAmounts;
    }

    /**
     * Returns Enabled.
     *
     * If `true`, the tax will be shown as enabled in the Square Point of Sale app.
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * Sets Enabled.
     *
     * If `true`, the tax will be shown as enabled in the Square Point of Sale app.
     *
     * @maps enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['name']                   = $this->name;
        $json['calculation_phase']      = $this->calculationPhase;
        $json['inclusion_type']         = $this->inclusionType;
        $json['percentage']             = $this->percentage;
        $json['applies_to_custom_amounts'] = $this->appliesToCustomAmounts;
        $json['enabled']                = $this->enabled;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
