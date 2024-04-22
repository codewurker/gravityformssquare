<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Contains information on the recipient of a fulfillment.
 */
class OrderFulfillmentRecipient implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $customerId;

    /**
     * @var string|null
     */
    private $displayName;

    /**
     * @var string|null
     */
    private $emailAddress;

    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var Address|null
     */
    private $address;

    /**
     * Returns Customer Id.
     *
     * The Customer ID of the customer associated with the fulfillment.
     *
     * If `customer_id` is provided, the fulfillment recipient's `display_name`,
     * `email_address`, and `phone_number` are automatically populated from the
     * targeted customer profile. If these fields are set in the request, the request
     * values will override the information from the customer profile. If the
     * targeted customer profile does not contain the necessary information and
     * these fields are left unset, the request will result in an error.
     */
    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    /**
     * Sets Customer Id.
     *
     * The Customer ID of the customer associated with the fulfillment.
     *
     * If `customer_id` is provided, the fulfillment recipient's `display_name`,
     * `email_address`, and `phone_number` are automatically populated from the
     * targeted customer profile. If these fields are set in the request, the request
     * values will override the information from the customer profile. If the
     * targeted customer profile does not contain the necessary information and
     * these fields are left unset, the request will result in an error.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * Returns Display Name.
     *
     * The display name of the fulfillment recipient.
     *
     * If provided, overrides the value pulled from the customer profile indicated by `customer_id`.
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * Sets Display Name.
     *
     * The display name of the fulfillment recipient.
     *
     * If provided, overrides the value pulled from the customer profile indicated by `customer_id`.
     *
     * @maps display_name
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * Returns Email Address.
     *
     * The email address of the fulfillment recipient.
     *
     * If provided, overrides the value pulled from the customer profile indicated by `customer_id`.
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * Sets Email Address.
     *
     * The email address of the fulfillment recipient.
     *
     * If provided, overrides the value pulled from the customer profile indicated by `customer_id`.
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Returns Phone Number.
     *
     * The phone number of the fulfillment recipient.
     *
     * If provided, overrides the value pulled from the customer profile indicated by `customer_id`.
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Sets Phone Number.
     *
     * The phone number of the fulfillment recipient.
     *
     * If provided, overrides the value pulled from the customer profile indicated by `customer_id`.
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Returns Address.
     *
     * Represents a physical address.
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * Sets Address.
     *
     * Represents a physical address.
     *
     * @maps address
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['customer_id']  = $this->customerId;
        $json['display_name'] = $this->displayName;
        $json['email_address'] = $this->emailAddress;
        $json['phone_number'] = $this->phoneNumber;
        $json['address']      = $this->address;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
