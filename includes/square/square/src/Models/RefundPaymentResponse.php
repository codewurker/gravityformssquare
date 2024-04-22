<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the fields that are included in the response body of
 * a request to the [RefundPayment](#endpoint-refunds-refundpayment) endpoint.
 *
 * Note: if there are errors processing the request, the refund field may not be
 * present, or it may be present in a FAILED state.
 */
class RefundPaymentResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var PaymentRefund|null
     */
    private $refund;

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
     * Returns Refund.
     *
     * Represents a refund of a payment made using Square. Contains information on
     * the original payment and the amount of money refunded.
     */
    public function getRefund(): ?PaymentRefund
    {
        return $this->refund;
    }

    /**
     * Sets Refund.
     *
     * Represents a refund of a payment made using Square. Contains information on
     * the original payment and the amount of money refunded.
     *
     * @maps refund
     */
    public function setRefund(?PaymentRefund $refund): void
    {
        $this->refund = $refund;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors'] = $this->errors;
        $json['refund'] = $this->refund;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
