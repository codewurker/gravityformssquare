# Square PHP SDK

[![Travis status](https://travis-ci.com/square/square-php-sdk.svg?branch=master)](https://travis-ci.com/square/square-php-sdk)
[![PHP version](https://badge.fury.io/ph/square%2Fsquare.svg)](https://badge.fury.io/ph/square%2Fsquare)
[![Apache-2 license](https://img.shields.io/badge/license-Apache2-brightgreen.svg)](https://www.apache.org/licenses/LICENSE-2.0)

Use this library to integrate Square payments into your app and grow your business with Square APIs including Catalog, Customers, Employees, Inventory, Labor, Locations, and Orders.

## Requirements

PHP 7.1+:

Installing
-----

##### Option 1: With Composer

The PHP SDK is available on Packagist. To add it to Composer, simply run:

```
$ composer require square/square
```

Or add this line under `"require"` to your composer.json:

```
"require": {
    ...
    "square/square": "*",
    ...
}
```
And then install your composer dependencies with
```
$ composer install
```
##### Option 2: From GitHub
Clone this repository, or download the zip into your project's folder and then add the following line in your code:
```
require('square-php-sdk/autoload.php');
```
*Note: you might have to change the path depending on your project's folder structure.*
##### Option 3: Without Command Line Access
If you cannot access the command line for your server, you can also install the SDK from github. Download the SDK from github with [this link](https://github.com/square/square-php-sdk/archive/master.zip), unzip it and add the following line to your php files that will need to access the SDK:
```
require('square-php-sdk-master/autoload.php');
```
*Note: you might have to change the path depending on where you place the SDK in relation to your other `php` files.*


## API documentation

### Payments
* [Payments]
* [Refunds]
* [Disputes]
* [Checkout]
* [Apple Pay]
* [Terminal]

### Orders
* [Orders]

### Items
* [Catalog]
* [Inventory]

### Customers
* [Customers]
* [Customer Groups]
* [Customer Segments]

### Loyalty
* [Loyalty]

### Business
* [Merchants]
* [Locations]
* [Devices]

### Team
* [Employees]
* [Labor]
* [Cash Drawers]

### Financials
* [Bank Accounts]

### Authorization APIs
* [Mobile Authorization]
* [O Auth]

### Deprecated APIs
* [V1 Locations]
* [V1 Employees]
* [V1 Transactions]
* [V1 Items]
* [Transactions]
* [Reporting]

## Usage


First time using Square? Here’s how to get started:

1. **Create a Square account.** If you don’t have one already, [sign up for a developer account].
1. **Create an application.** Go to your [Developer Dashboard] and create your first application. All you need to do is give it a name. When you’re doing this for your production application, enter the name as you would want a customer to see it.
1. **Make your first API call.** Almost all Square API calls require a location ID. You’ll make your first call to #list_locations, which happens to be one of the API calls that don’t require a location ID. For more information about locations, see the [Locations] API documentation.

Now let’s call your first Square API. Open your favorite text editor, create a new file called `index.php`, and copy the following code into that file:



```php
<?php


require 'vendor/autoload.php';

use Square\SquareClient;
use Square\LocationsApi;
use Square\Exceptions\ApiException;
use Square\Http\ApiResponse;
use Square\Models\ListLocationsResponse;
use Square\Environment;


$client = new SquareClient([
    'accessToken' => 'YOUR SANDBOX ACCESS TOKEN HERE',
    'environment' => Environment::SANDBOX,
]);

$locationsApi = $client->getLocationsApi();
$apiResponse = $locationsApi->listLocations();

if ($apiResponse->isSuccess()) {
    $listLocationsResponse = $apiResponse->getResult();
    $locationsList = $listLocationsResponse->getLocations()
    foreach ($locationsList as $location) {
       print_r($location);
    }
} else {
    print_r($apiResponse->getErrors());
}
```

Next, get an access token and reference it in your code. Go back to your application in the Developer Dashboard, in the Sandbox section click Show in the Sandbox Access Token box, copy that access token, and replace `'YOUR SANDBOX ACCESS TOKEN HERE'` with that token.

**Important** When you eventually switch from trying things out on sandbox to actually working with your real production resources, you should not embed the access token in your code. Make sure you store and access your production access tokens securely.

Now save `index.php` and run it:

```sh
php -S localhost:8000
```


If your call is successful, you’ll get a response that looks like this:

```
stdClass Object
(
    [id] => KXKXSFEKT2587
    [name] => My Location
    [address] => stdClass Object
        (
            [address_line_1] => 1455 Market Street
            [locality] => San Francisco
            [administrative_district_level_1] => CA
            [postal_code] => 94103
            [country] => US
        )
# ...
```

Yay! You successfully made your first call. If you didn’t, you would see an error message that looks something like this:

```
Array
(
    [0] => Square\Models\Error Object
        (
            [category:Square\Models\Error:private] => AUTHENTICATION_ERROR
            [code:Square\Models\Error:private] => UNAUTHORIZED
            [detail:Square\Models\Error:private] => This request could not be authorized.
            [field:Square\Models\Error:private] => 
        )

)
```

This error was returned when an invalid token was used to call the API.

After you’ve tried out the Square APIs and tested your application using sandbox, you will want to switch to your production credentials so that you can manage real Square resources. Don't forget to switch your access token from sandbox to production for real data.

## SDK patterns
If you know a few patterns, you’ll be able to call any API in the SDK. Here are some important ones:

### Get an access token

To use the Square API to manage the resources (such as payments, orders, customers, etc.) of a Square account, you need to create an application (or use an existing one) in the Developer Dashboard and get an access token.

When you call a Square API, you call it using an access key. An access key has specific permissions to resources in a specific Square account that can be accessed by a specific application in a specific developer account.
Use an access token that is appropriate for your use case. There are two options:

- To manage the resources for your own Square account, use the Personal Access Token for the application created in your Square account.
- To manage resources for other Square accounts, use OAuth to ask owners of the accounts you want to manage so that you can work on their behalf. When you implement OAuth, you ask the Square account holder for permission to manage resources in their account (you can define the specific resources to access) and get an OAuth access token and refresh token for their account.

**Important** For both use cases, make sure you store and access the tokens securely.

### Import and Instantiate the Client Class

To use the Square API, you import the Client class, instantiate a Client object, and initialize it with the appropriate access token. Here’s how:

- Instantiate a `SquareClient` object with the access token for the Square account whose resources you want to manage. To access sandbox resources, initialize the `SquareClient` with environment set to sandbox:

```php
use Square\SquareClient;
use Square\Environment;

$client = new SquareClient([
    'accessToken' => 'YOUR SANDBOX ACCESS TOKEN HERE',
    'environment' => Environment::SANDBOX
]);
```

- To access production resources, set environment to production:

```php
use Square\SquareClient;
use Square\Environment;

$client = new SquareClient([
    'accessToken' => 'YOUR PRODUCTION ACCESS TOKEN HERE',
    'environment' => Environment::PRODUCTION
]);
```

### Get an Instance of an API object and call its methods

Each API is implemented as a class. The Client object instantiates every API class and exposes them as properties so you can easily start using any Square API. You work with an API by calling methods on an instance of an API class. Here’s how:

- Work with an API by calling the methods on the API object. For example, you would call listCustomers to get a list of all customers in the Square account:

```php
$result = $client->getCustomersApi()->listCustomers();
```

See the SDK documentation for the list of methods for each API class.

Pass complex parameters (such as create, update, search, etc.) as a Request object. For example, you would pass a `CreateCustomerRequest` containing the values used to create a new customer using create_customer:

```php
use Square\SquareClient;
use Square\Models\CreateCustomerRequest;
use Square\Environment;

$client = new SquareClient([
    "accessToken" => "SQUARE_SANDBOX_ACCESS_TOKEN",
    "environment" => Environment::SANDBOX
]);

$customersApi = $client->getCustomersApi();

// Create customer
$request = new CreateCustomerRequest;
$request->setGivenName('Amelia');
$request->setFamilyName('Earhart');
$request->setPhoneNumber("1-252-555-4240");
$request->setNote('A customer');

$result = $customersApi->createCustomer($request);

if ($result->isSuccess()) {
    print_r($result->getResult()->getCustomer());
} else {
    print_r($result->getErrors());
}
```

If your call succeeds, you’ll see a response that looks like this:
```
Square\Models\Customer Object
(
    [id:Square\Models\Customer:private] => 2CN457HSFGR11CKQGHDECEZCDC
    [createdAt:Square\Models\Customer:private] => 2020-06-05T00:42:54.499Z
    [updatedAt:Square\Models\Customer:private] => 2020-06-05T00:42:54Z
    [cards:Square\Models\Customer:private] => 
    [givenName:Square\Models\Customer:private] => Amelia
    [familyName:Square\Models\Customer:private] => Earhart
    [nickname:Square\Models\Customer:private] => 
    [companyName:Square\Models\Customer:private] => 
    [emailAddress:Square\Models\Customer:private] => 
    [address:Square\Models\Customer:private] => 
    [phoneNumber:Square\Models\Customer:private] =>  1-252-555-4240
    [birthday:Square\Models\Customer:private] => 
    [referenceId:Square\Models\Customer:private] => 
    [note:Square\Models\Customer:private] => a customer
    [preferences:Square\Models\Customer:private] => Square\Models\CustomerPreferences Object
        (
            [emailUnsubscribed:Square\Models\CustomerPreferences:private] => 
        )

    [groups:Square\Models\Customer:private] => 
    [creationSource:Square\Models\Customer:private] => THIRD_PARTY
    [groupIds:Square\Models\Customer:private] => 
    [segmentIds:Square\Models\Customer:private] => 
)
```

- Use idempotency for create, update, or other calls that you want to avoid calling twice. To make an idempotent API call, you add the idempotency_key with a unique value in the API call’s request.
- Specify a location ID for APIs such as Transactions, Orders, and Checkout that deal with payments. When a payment or order is created in Square, it is always associated with a location.

### Handle the response

API calls return a response object that contains properties that describe both the request (headers and request) and the response (status_code, reason_phrase, text, errors, body, and cursor). The response also has `isSuccess()` and `isError()` helper methods so you can easily determine the success or failure of a call:

```php
if ($apiResponse->isSuccess()) {
    $listLocationsResponse = $apiResponse->getResult();
} else {
    print_r($apiResponse->getErrors());
}
```

- Read the response payload. The response payload is returned as an array from the `getResult` method. For retrieve calls, an object containing a single item is returned with a key name that is the name of the object (for example, customer). For list calls, an object containing a Array of objects is returned with a key name that is the plural of the object name (for example, customers).
- Make sure you get all items returned in a list call by checking the cursor value returned in the API response. When you call a list API the first time, set the cursor to an empty String or omit it from the API request. If the API response contains a cursor with a value, you call the API again to get the next page of items and continue to call that API again until the cursor is an empty String.

## Tests

First, clone the gem locally and `cd` into the directory.

```sh
git clone https://github.com/square/square-php-sdk.git
cd square-php-sdk
```

Next, make sure you've downloaded Composer, following the instructions [here](https://getcomposer.org/download/)
and then run the following command from the directory containing `composer.json`:

```
composer install
```


Before running the tests, find a sandbox token in your [Developer Dashboard] and set a `SANDBOX_ACCESS_TOKEN` environment variable.

```sh
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();
$appId = getenv('SANDBOX_APP_ID');
$appAccessToken = getenv('SANDBOX_ACCESS_TOKEN');
$appSecret =getenv('SANDBOX_APP_SECRET');
```

And run the tests.

```sh
php composer.phar run test
```

## Learn more

The Square Platform is built on the [Square API]. Square has a number of other SDKs that enable you to securely handle credit card information on both mobile and web so that you can process payments via the Square API.

You can also use the Square API to create applications or services that work with payments, orders, inventory, etc. that have been created and managed in Square’s in-person hardware products (Square Point of Sale and Square Register).



[//]: # "Link anchor definitions"
[Square Logo]: https://docs.connect.squareup.com/images/github/github-square-logo.svg
[Developer Dashboard]: https://developer.squareup.com/apps
[Square API]: https://squareup.com/developers
[sign up for a developer account]: https://squareup.com/signup?v=developers
[Client]: doc/client.md
[Devices]: doc/devices.md
[Disputes]: doc/disputes.md
[Terminal]: doc/terminal.md
[Cash Drawers]: doc/cash-drawers.md
[Customer Groups]: doc/customer-groups.md
[Customer Segments]: doc/customer-segments.md
[Bank Accounts]: doc/bank-accounts
[Payments]: doc/payments.md
[Checkout]: doc/checkout.md
[Catalog]: doc/catalog.md
[Customers]: doc/customers.md
[Employees]: doc/employees.md
[Inventory]: doc/inventory.md
[Labor]: doc/labor.md
[Loyalty]: doc/loyalty.md
[Locations]: doc/locations.md
[Merchants]: doc/merchants.md
[Orders]: doc/orders.md
[Apple Pay]: doc/apple-pay.md
[Refunds]: doc/refunds.md
[Reporting]: doc/reporting.md
[Mobile Authorization]: doc/mobile-authorization.md
[O Auth]: doc/o-auth.md
[V1 Locations]: doc/v1-locations.md
[V1 Employees]: doc/v1-employees.md
[V1 Transactions]: doc/v1-transactions.md
[V1 Items]: doc/v1-items.md
[Transactions]: doc/transactions.md