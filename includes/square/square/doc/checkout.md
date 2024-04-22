# Checkout

```php
$checkoutApi = $client->getCheckoutApi();
```

## Class Name

`CheckoutApi`

## Create Checkout

Links a `checkoutId` to a `checkout_page_url` that customers will
be directed to in order to provide their payment information using a
payment processing workflow hosted on connect.squareup.com.

```php
function createCheckout(string $locationId, CreateCheckoutRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the business location to associate the checkout with. |
| `body` | [`CreateCheckoutRequest`](/doc/models/create-checkout-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`CreateCheckoutResponse`](/doc/models/create-checkout-response.md).

### Example Usage

```php
$locationId = 'location_id4';
$body_idempotencyKey = '86ae1696-b1e3-4328-af6d-f1e04d947ad6';
$body_order = new Models\CreateOrderRequest;
$body_order_order_locationId = 'location_id';
$body_order->setOrder(new Models\Order(
    $body_order_order_locationId
));
$body_order->getOrder()->setReferenceId('reference_id');
$body_order->getOrder()->setCustomerId('customer_id');
$body_order_order_lineItems = [];

$body_order_order_lineItems_0_quantity = '2';
$body_order_order_lineItems[0] = new Models\OrderLineItem(
    $body_order_order_lineItems_0_quantity
);
$body_order_order_lineItems[0]->setName('Printed T Shirt');
$body_order_order_lineItems_0_appliedTaxes = [];

$body_order_order_lineItems_0_appliedTaxes_0_taxUid = '38ze1696-z1e3-5628-af6d-f1e04d947fg3';
$body_order_order_lineItems_0_appliedTaxes[0] = new Models\OrderLineItemAppliedTax(
    $body_order_order_lineItems_0_appliedTaxes_0_taxUid
);
$body_order_order_lineItems[0]->setAppliedTaxes($body_order_order_lineItems_0_appliedTaxes);

$body_order_order_lineItems_0_appliedDiscounts = [];

$body_order_order_lineItems_0_appliedDiscounts_0_discountUid = '56ae1696-z1e3-9328-af6d-f1e04d947gd4';
$body_order_order_lineItems_0_appliedDiscounts[0] = new Models\OrderLineItemAppliedDiscount(
    $body_order_order_lineItems_0_appliedDiscounts_0_discountUid
);
$body_order_order_lineItems[0]->setAppliedDiscounts($body_order_order_lineItems_0_appliedDiscounts);

$body_order_order_lineItems[0]->setBasePriceMoney(new Models\Money);
$body_order_order_lineItems[0]->getBasePriceMoney()->setAmount(1500);
$body_order_order_lineItems[0]->getBasePriceMoney()->setCurrency(Models\Currency::USD);

$body_order_order_lineItems_1_quantity = '1';
$body_order_order_lineItems[1] = new Models\OrderLineItem(
    $body_order_order_lineItems_1_quantity
);
$body_order_order_lineItems[1]->setName('Slim Jeans');
$body_order_order_lineItems[1]->setBasePriceMoney(new Models\Money);
$body_order_order_lineItems[1]->getBasePriceMoney()->setAmount(2500);
$body_order_order_lineItems[1]->getBasePriceMoney()->setCurrency(Models\Currency::USD);

$body_order_order_lineItems_2_quantity = '3';
$body_order_order_lineItems[2] = new Models\OrderLineItem(
    $body_order_order_lineItems_2_quantity
);
$body_order_order_lineItems[2]->setName('Woven Sweater');
$body_order_order_lineItems[2]->setBasePriceMoney(new Models\Money);
$body_order_order_lineItems[2]->getBasePriceMoney()->setAmount(3500);
$body_order_order_lineItems[2]->getBasePriceMoney()->setCurrency(Models\Currency::USD);
$body_order->getOrder()->setLineItems($body_order_order_lineItems);

$body_order_order_taxes = [];

$body_order_order_taxes[0] = new Models\OrderLineItemTax;
$body_order_order_taxes[0]->setUid('38ze1696-z1e3-5628-af6d-f1e04d947fg3');
$body_order_order_taxes[0]->setType(Models\OrderLineItemTaxType::INCLUSIVE);
$body_order_order_taxes[0]->setPercentage('7.75');
$body_order_order_taxes[0]->setScope(Models\OrderLineItemTaxScope::LINE_ITEM);
$body_order->getOrder()->setTaxes($body_order_order_taxes);

$body_order_order_discounts = [];

$body_order_order_discounts[0] = new Models\OrderLineItemDiscount;
$body_order_order_discounts[0]->setUid('56ae1696-z1e3-9328-af6d-f1e04d947gd4');
$body_order_order_discounts[0]->setType(Models\OrderLineItemDiscountType::FIXED_AMOUNT);
$body_order_order_discounts[0]->setAmountMoney(new Models\Money);
$body_order_order_discounts[0]->getAmountMoney()->setAmount(100);
$body_order_order_discounts[0]->getAmountMoney()->setCurrency(Models\Currency::USD);
$body_order_order_discounts[0]->setScope(Models\OrderLineItemDiscountScope::LINE_ITEM);
$body_order->getOrder()->setDiscounts($body_order_order_discounts);

$body_order->setIdempotencyKey('12ae1696-z1e3-4328-af6d-f1e04d947gd4');
$body = new Models\CreateCheckoutRequest(
    $body_idempotencyKey,
    $body_order
);
$body->setAskForShippingAddress(true);
$body->setMerchantSupportEmail('merchant+support@website.com');
$body->setPrePopulateBuyerEmail('example@email.com');
$body->setPrePopulateShippingAddress(new Models\Address);
$body->getPrePopulateShippingAddress()->setAddressLine1('1455 Market St.');
$body->getPrePopulateShippingAddress()->setAddressLine2('Suite 600');
$body->getPrePopulateShippingAddress()->setLocality('San Francisco');
$body->getPrePopulateShippingAddress()->setAdministrativeDistrictLevel1('CA');
$body->getPrePopulateShippingAddress()->setPostalCode('94103');
$body->getPrePopulateShippingAddress()->setCountry(Models\Country::US);
$body->getPrePopulateShippingAddress()->setFirstName('Jane');
$body->getPrePopulateShippingAddress()->setLastName('Doe');
$body->setRedirectUrl('https://merchant.website.com/order-confirm');
$body_additionalRecipients = [];

$body_additionalRecipients_0_locationId = '057P5VYJ4A5X1';
$body_additionalRecipients_0_description = 'Application fees';
$body_additionalRecipients[0] = new Models\ChargeRequestAdditionalRecipient(
    $body_additionalRecipients_0_locationId,
    $body_additionalRecipients_0_description,
    $body_additionalRecipients_0_amountMoney
);
$body->setAdditionalRecipients($body_additionalRecipients);


$apiResponse = $checkoutApi->createCheckout($locationId, $body);

if ($apiResponse->isSuccess()) {
    $createCheckoutResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

