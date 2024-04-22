<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Reflects the current status of a card payment.
 */
class CardPaymentDetails implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $status;

    /**
     * @var Card|null
     */
    private $card;

    /**
     * @var string|null
     */
    private $entryMethod;

    /**
     * @var string|null
     */
    private $cvvStatus;

    /**
     * @var string|null
     */
    private $avsStatus;

    /**
     * @var string|null
     */
    private $authResultCode;

    /**
     * @var string|null
     */
    private $applicationIdentifier;

    /**
     * @var string|null
     */
    private $applicationName;

    /**
     * @var string|null
     */
    private $applicationCryptogram;

    /**
     * @var string|null
     */
    private $verificationMethod;

    /**
     * @var string|null
     */
    private $verificationResults;

    /**
     * @var string|null
     */
    private $statementDescription;

    /**
     * @var DeviceDetails|null
     */
    private $deviceDetails;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Status.
     *
     * The card payment's current state. It can be one of: `AUTHORIZED`, `CAPTURED`, `VOIDED`,
     * `FAILED`.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     *
     * The card payment's current state. It can be one of: `AUTHORIZED`, `CAPTURED`, `VOIDED`,
     * `FAILED`.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Card.
     *
     * Represents the payment details of a card to be used for payments. These
     * details are determined by the `card_nonce` generated by `SqPaymentForm`.
     */
    public function getCard(): ?Card
    {
        return $this->card;
    }

    /**
     * Sets Card.
     *
     * Represents the payment details of a card to be used for payments. These
     * details are determined by the `card_nonce` generated by `SqPaymentForm`.
     *
     * @maps card
     */
    public function setCard(?Card $card): void
    {
        $this->card = $card;
    }

    /**
     * Returns Entry Method.
     *
     * The method used to enter the card's details for the payment.  Can be
     * `KEYED`, `SWIPED`, `EMV`, `ON_FILE`, or `CONTACTLESS`.
     */
    public function getEntryMethod(): ?string
    {
        return $this->entryMethod;
    }

    /**
     * Sets Entry Method.
     *
     * The method used to enter the card's details for the payment.  Can be
     * `KEYED`, `SWIPED`, `EMV`, `ON_FILE`, or `CONTACTLESS`.
     *
     * @maps entry_method
     */
    public function setEntryMethod(?string $entryMethod): void
    {
        $this->entryMethod = $entryMethod;
    }

    /**
     * Returns Cvv Status.
     *
     * Status code returned from the Card Verification Value (CVV) check. Can be
     * `CVV_ACCEPTED`, `CVV_REJECTED`, `CVV_NOT_CHECKED`.
     */
    public function getCvvStatus(): ?string
    {
        return $this->cvvStatus;
    }

    /**
     * Sets Cvv Status.
     *
     * Status code returned from the Card Verification Value (CVV) check. Can be
     * `CVV_ACCEPTED`, `CVV_REJECTED`, `CVV_NOT_CHECKED`.
     *
     * @maps cvv_status
     */
    public function setCvvStatus(?string $cvvStatus): void
    {
        $this->cvvStatus = $cvvStatus;
    }

    /**
     * Returns Avs Status.
     *
     * Status code returned from the Address Verification System (AVS) check. Can be
     * `AVS_ACCEPTED`, `AVS_REJECTED`, `AVS_NOT_CHECKED`.
     */
    public function getAvsStatus(): ?string
    {
        return $this->avsStatus;
    }

    /**
     * Sets Avs Status.
     *
     * Status code returned from the Address Verification System (AVS) check. Can be
     * `AVS_ACCEPTED`, `AVS_REJECTED`, `AVS_NOT_CHECKED`.
     *
     * @maps avs_status
     */
    public function setAvsStatus(?string $avsStatus): void
    {
        $this->avsStatus = $avsStatus;
    }

    /**
     * Returns Auth Result Code.
     *
     * Status code returned by the card issuer that describes the payment's
     * authorization status.
     */
    public function getAuthResultCode(): ?string
    {
        return $this->authResultCode;
    }

    /**
     * Sets Auth Result Code.
     *
     * Status code returned by the card issuer that describes the payment's
     * authorization status.
     *
     * @maps auth_result_code
     */
    public function setAuthResultCode(?string $authResultCode): void
    {
        $this->authResultCode = $authResultCode;
    }

    /**
     * Returns Application Identifier.
     *
     * For EMV payments, identifies the EMV application used for the payment.
     */
    public function getApplicationIdentifier(): ?string
    {
        return $this->applicationIdentifier;
    }

    /**
     * Sets Application Identifier.
     *
     * For EMV payments, identifies the EMV application used for the payment.
     *
     * @maps application_identifier
     */
    public function setApplicationIdentifier(?string $applicationIdentifier): void
    {
        $this->applicationIdentifier = $applicationIdentifier;
    }

    /**
     * Returns Application Name.
     *
     * For EMV payments, the human-readable name of the EMV application used for the payment.
     */
    public function getApplicationName(): ?string
    {
        return $this->applicationName;
    }

    /**
     * Sets Application Name.
     *
     * For EMV payments, the human-readable name of the EMV application used for the payment.
     *
     * @maps application_name
     */
    public function setApplicationName(?string $applicationName): void
    {
        $this->applicationName = $applicationName;
    }

    /**
     * Returns Application Cryptogram.
     *
     * For EMV payments, the cryptogram generated for the payment.
     */
    public function getApplicationCryptogram(): ?string
    {
        return $this->applicationCryptogram;
    }

    /**
     * Sets Application Cryptogram.
     *
     * For EMV payments, the cryptogram generated for the payment.
     *
     * @maps application_cryptogram
     */
    public function setApplicationCryptogram(?string $applicationCryptogram): void
    {
        $this->applicationCryptogram = $applicationCryptogram;
    }

    /**
     * Returns Verification Method.
     *
     * For EMV payments, method used to verify the cardholder's identity.  Can be one of
     * `PIN`, `SIGNATURE`, `PIN_AND_SIGNATURE`, `ON_DEVICE`, or `NONE`.
     */
    public function getVerificationMethod(): ?string
    {
        return $this->verificationMethod;
    }

    /**
     * Sets Verification Method.
     *
     * For EMV payments, method used to verify the cardholder's identity.  Can be one of
     * `PIN`, `SIGNATURE`, `PIN_AND_SIGNATURE`, `ON_DEVICE`, or `NONE`.
     *
     * @maps verification_method
     */
    public function setVerificationMethod(?string $verificationMethod): void
    {
        $this->verificationMethod = $verificationMethod;
    }

    /**
     * Returns Verification Results.
     *
     * For EMV payments, the results of the cardholder verification.  Can be one of
     * `SUCCESS`, `FAILURE`, or `UNKNOWN`.
     */
    public function getVerificationResults(): ?string
    {
        return $this->verificationResults;
    }

    /**
     * Sets Verification Results.
     *
     * For EMV payments, the results of the cardholder verification.  Can be one of
     * `SUCCESS`, `FAILURE`, or `UNKNOWN`.
     *
     * @maps verification_results
     */
    public function setVerificationResults(?string $verificationResults): void
    {
        $this->verificationResults = $verificationResults;
    }

    /**
     * Returns Statement Description.
     *
     * The statement description sent to the card networks.
     *
     * Note: The actual statement description will vary and is likely to be truncated and appended with
     * additional information on a per issuer basis.
     */
    public function getStatementDescription(): ?string
    {
        return $this->statementDescription;
    }

    /**
     * Sets Statement Description.
     *
     * The statement description sent to the card networks.
     *
     * Note: The actual statement description will vary and is likely to be truncated and appended with
     * additional information on a per issuer basis.
     *
     * @maps statement_description
     */
    public function setStatementDescription(?string $statementDescription): void
    {
        $this->statementDescription = $statementDescription;
    }

    /**
     * Returns Device Details.
     *
     * Details about the device that took the payment.
     */
    public function getDeviceDetails(): ?DeviceDetails
    {
        return $this->deviceDetails;
    }

    /**
     * Sets Device Details.
     *
     * Details about the device that took the payment.
     *
     * @maps device_details
     */
    public function setDeviceDetails(?DeviceDetails $deviceDetails): void
    {
        $this->deviceDetails = $deviceDetails;
    }

    /**
     * Returns Errors.
     *
     * Information on errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     *
     * Information on errors encountered during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['status']                = $this->status;
        $json['card']                  = $this->card;
        $json['entry_method']          = $this->entryMethod;
        $json['cvv_status']            = $this->cvvStatus;
        $json['avs_status']            = $this->avsStatus;
        $json['auth_result_code']      = $this->authResultCode;
        $json['application_identifier'] = $this->applicationIdentifier;
        $json['application_name']      = $this->applicationName;
        $json['application_cryptogram'] = $this->applicationCryptogram;
        $json['verification_method']   = $this->verificationMethod;
        $json['verification_results']  = $this->verificationResults;
        $json['statement_description'] = $this->statementDescription;
        $json['device_details']        = $this->deviceDetails;
        $json['errors']                = $this->errors;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
