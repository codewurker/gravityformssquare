<?php

declare(strict_types=1);

namespace Square;

use Square\Apis;

/**
 * Square client class
 */
class SquareClient implements ConfigurationInterface
{
    private $mobileAuthorization;
    private $oAuth;
    private $v1Locations;
    private $v1Employees;
    private $v1Transactions;
    private $v1Items;
    private $applePay;
    private $bankAccounts;
    private $cashDrawers;
    private $catalog;
    private $customers;
    private $customerGroups;
    private $customerSegments;
    private $devices;
    private $disputes;
    private $employees;
    private $inventory;
    private $labor;
    private $locations;
    private $reporting;
    private $checkout;
    private $orders;
    private $transactions;
    private $loyalty;
    private $merchants;
    private $payments;
    private $refunds;
    private $terminal;

    private $timeout = ConfigurationDefaults::TIMEOUT;
    private $accessToken = ConfigurationDefaults::ACCESS_TOKEN;
    private $additionalHeaders = ConfigurationDefaults::ADDITIONAL_HEADERS;
    private $environment = ConfigurationDefaults::ENVIRONMENT;

    public function __construct(array $configOptions = null)
    {
        if (isset($configOptions['timeout'])) {
            $this->timeout = $configOptions['timeout'];
        }
        if (isset($configOptions['accessToken'])) {
            $this->accessToken = $configOptions['accessToken'];
        }
        if (isset($configOptions['additionalHeaders'])) {
            $this->additionalHeaders = $configOptions['additionalHeaders'];
            \Square\ApiHelper::assertHeaders($this->additionalHeaders);
        }
        if (isset($configOptions['environment'])) {
            $this->environment = $configOptions['environment'];
        }
    }

    /**
     * Get the client configuration as an associative array
     */
    public function getConfiguration(): array
    {
        $configMap = [];

        if (isset($this->timeout)) {
            $configMap['timeout'] = $this->timeout;
        }
        if (isset($this->accessToken)) {
            $configMap['accessToken'] = $this->accessToken;
        }
        if (isset($this->additionalHeaders)) {
            $configMap['additionalHeaders'] = $this->additionalHeaders;
        }
        if (isset($this->environment)) {
            $configMap['environment'] = $this->environment;
        }

        return $configMap;
    }

    /**
     * Clone this client and override given configuration options
     */
    public function withConfiguration(array $configOptions): self
    {
        return new self(\array_merge($this->getConfiguration(), $configOptions));
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getAdditionalHeaders(): array
    {
        return $this->additionalHeaders;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Get current SDK version
     */
    public function getSdkVersion(): string
    {
        return '5.0.0.20200528';
    }


    public function getSquareVersion(): string
    {
        return '2020-05-28';
    }

    /**
     * Get the base uri for a given server in the current environment
     *
     * @param  string $server Server name
     *
     * @return string         Base URI
     */
    public function getBaseUri(string $server = Server::DEFAULT_): string
    {
        return static::ENVIRONMENT_MAP[$this->environment][$server];
    }

    /**
     * Returns Mobile Authorization Api
     */
    public function getMobileAuthorizationApi(): Apis\MobileAuthorizationApi
    {
        if ($this->mobileAuthorization == null) {
            $this->mobileAuthorization = new Apis\MobileAuthorizationApi($this);
        }
        return $this->mobileAuthorization;
    }

    /**
     * Returns O Auth Api
     */
    public function getOAuthApi(): Apis\OAuthApi
    {
        if ($this->oAuth == null) {
            $this->oAuth = new Apis\OAuthApi($this);
        }
        return $this->oAuth;
    }

    /**
     * Returns V1 Locations Api
     */
    public function getV1LocationsApi(): Apis\V1LocationsApi
    {
        if ($this->v1Locations == null) {
            $this->v1Locations = new Apis\V1LocationsApi($this);
        }
        return $this->v1Locations;
    }

    /**
     * Returns V1 Employees Api
     */
    public function getV1EmployeesApi(): Apis\V1EmployeesApi
    {
        if ($this->v1Employees == null) {
            $this->v1Employees = new Apis\V1EmployeesApi($this);
        }
        return $this->v1Employees;
    }

    /**
     * Returns V1 Transactions Api
     */
    public function getV1TransactionsApi(): Apis\V1TransactionsApi
    {
        if ($this->v1Transactions == null) {
            $this->v1Transactions = new Apis\V1TransactionsApi($this);
        }
        return $this->v1Transactions;
    }

    /**
     * Returns V1 Items Api
     */
    public function getV1ItemsApi(): Apis\V1ItemsApi
    {
        if ($this->v1Items == null) {
            $this->v1Items = new Apis\V1ItemsApi($this);
        }
        return $this->v1Items;
    }

    /**
     * Returns Apple Pay Api
     */
    public function getApplePayApi(): Apis\ApplePayApi
    {
        if ($this->applePay == null) {
            $this->applePay = new Apis\ApplePayApi($this);
        }
        return $this->applePay;
    }

    /**
     * Returns Bank Accounts Api
     */
    public function getBankAccountsApi(): Apis\BankAccountsApi
    {
        if ($this->bankAccounts == null) {
            $this->bankAccounts = new Apis\BankAccountsApi($this);
        }
        return $this->bankAccounts;
    }

    /**
     * Returns Cash Drawers Api
     */
    public function getCashDrawersApi(): Apis\CashDrawersApi
    {
        if ($this->cashDrawers == null) {
            $this->cashDrawers = new Apis\CashDrawersApi($this);
        }
        return $this->cashDrawers;
    }

    /**
     * Returns Catalog Api
     */
    public function getCatalogApi(): Apis\CatalogApi
    {
        if ($this->catalog == null) {
            $this->catalog = new Apis\CatalogApi($this);
        }
        return $this->catalog;
    }

    /**
     * Returns Customers Api
     */
    public function getCustomersApi(): Apis\CustomersApi
    {
        if ($this->customers == null) {
            $this->customers = new Apis\CustomersApi($this);
        }
        return $this->customers;
    }

    /**
     * Returns Customer Groups Api
     */
    public function getCustomerGroupsApi(): Apis\CustomerGroupsApi
    {
        if ($this->customerGroups == null) {
            $this->customerGroups = new Apis\CustomerGroupsApi($this);
        }
        return $this->customerGroups;
    }

    /**
     * Returns Customer Segments Api
     */
    public function getCustomerSegmentsApi(): Apis\CustomerSegmentsApi
    {
        if ($this->customerSegments == null) {
            $this->customerSegments = new Apis\CustomerSegmentsApi($this);
        }
        return $this->customerSegments;
    }

    /**
     * Returns Devices Api
     */
    public function getDevicesApi(): Apis\DevicesApi
    {
        if ($this->devices == null) {
            $this->devices = new Apis\DevicesApi($this);
        }
        return $this->devices;
    }

    /**
     * Returns Disputes Api
     */
    public function getDisputesApi(): Apis\DisputesApi
    {
        if ($this->disputes == null) {
            $this->disputes = new Apis\DisputesApi($this);
        }
        return $this->disputes;
    }

    /**
     * Returns Employees Api
     */
    public function getEmployeesApi(): Apis\EmployeesApi
    {
        if ($this->employees == null) {
            $this->employees = new Apis\EmployeesApi($this);
        }
        return $this->employees;
    }

    /**
     * Returns Inventory Api
     */
    public function getInventoryApi(): Apis\InventoryApi
    {
        if ($this->inventory == null) {
            $this->inventory = new Apis\InventoryApi($this);
        }
        return $this->inventory;
    }

    /**
     * Returns Labor Api
     */
    public function getLaborApi(): Apis\LaborApi
    {
        if ($this->labor == null) {
            $this->labor = new Apis\LaborApi($this);
        }
        return $this->labor;
    }

    /**
     * Returns Locations Api
     */
    public function getLocationsApi(): Apis\LocationsApi
    {
        if ($this->locations == null) {
            $this->locations = new Apis\LocationsApi($this);
        }
        return $this->locations;
    }

    /**
     * Returns Reporting Api
     */
    public function getReportingApi(): Apis\ReportingApi
    {
        if ($this->reporting == null) {
            $this->reporting = new Apis\ReportingApi($this);
        }
        return $this->reporting;
    }

    /**
     * Returns Checkout Api
     */
    public function getCheckoutApi(): Apis\CheckoutApi
    {
        if ($this->checkout == null) {
            $this->checkout = new Apis\CheckoutApi($this);
        }
        return $this->checkout;
    }

    /**
     * Returns Orders Api
     */
    public function getOrdersApi(): Apis\OrdersApi
    {
        if ($this->orders == null) {
            $this->orders = new Apis\OrdersApi($this);
        }
        return $this->orders;
    }

    /**
     * Returns Transactions Api
     */
    public function getTransactionsApi(): Apis\TransactionsApi
    {
        if ($this->transactions == null) {
            $this->transactions = new Apis\TransactionsApi($this);
        }
        return $this->transactions;
    }

    /**
     * Returns Loyalty Api
     */
    public function getLoyaltyApi(): Apis\LoyaltyApi
    {
        if ($this->loyalty == null) {
            $this->loyalty = new Apis\LoyaltyApi($this);
        }
        return $this->loyalty;
    }

    /**
     * Returns Merchants Api
     */
    public function getMerchantsApi(): Apis\MerchantsApi
    {
        if ($this->merchants == null) {
            $this->merchants = new Apis\MerchantsApi($this);
        }
        return $this->merchants;
    }

    /**
     * Returns Payments Api
     */
    public function getPaymentsApi(): Apis\PaymentsApi
    {
        if ($this->payments == null) {
            $this->payments = new Apis\PaymentsApi($this);
        }
        return $this->payments;
    }

    /**
     * Returns Refunds Api
     */
    public function getRefundsApi(): Apis\RefundsApi
    {
        if ($this->refunds == null) {
            $this->refunds = new Apis\RefundsApi($this);
        }
        return $this->refunds;
    }

    /**
     * Returns Terminal Api
     */
    public function getTerminalApi(): Apis\TerminalApi
    {
        if ($this->terminal == null) {
            $this->terminal = new Apis\TerminalApi($this);
        }
        return $this->terminal;
    }

    /**
     * A map of all baseurls used in different environments and servers
     *
     * @var array
     */
    private const ENVIRONMENT_MAP = [
        Environment::PRODUCTION => [
            Server::DEFAULT_ => 'https://connect.squareup.com',
        ],
        Environment::SANDBOX => [
            Server::DEFAULT_ => 'https://connect.squareupsandbox.com',
        ],
    ];
}
