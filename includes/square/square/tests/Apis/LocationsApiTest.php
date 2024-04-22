<?php
namespace Square\Tests;

use Square\Exceptions\ApiException;
use Square\Exceptions;
use Square\ApiHelper;
use Square\Models;
use PHPUnit\Framework\TestCase;

class LocationsApiTest extends TestCase
{
    /**
     * @var \Square\Apis\LocationsApi Controller instance
     */
    protected static $controller;

    /**
     * @var HttpCallBackCatcher Callback
     */
    protected static $httpResponse;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        $config = ClientFactory::create();
        self::$httpResponse = new HttpCallBackCatcher();
        self::$controller = new \Square\Apis\LocationsApi($config, self::$httpResponse);
    }

    /**
     * Provides information of all locations of a business.
     * Most other Connect API endpoints have a required `location_id` path parameter.
     * The `id` field of the [`Location`](#type-location) objects returned by this
     * endpoint correspond to that `location_id` parameter.
     */
    public function testListLocations()
    {

        // Set callback and perform API call
        $result = null;
        try {
            $result = self::$controller->listLocations()->getResult();
        } catch (ApiException $e) {
        }

        // Test response code
        $this->assertEquals(
            200,
            self::$httpResponse->getResponse()->getStatusCode(),
            "Status is not 200"
        );
    }
}
