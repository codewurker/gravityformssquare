<?php

declare(strict_types=1);

namespace Square\Apis;

use Square\Exceptions\ApiException;
use Square\ApiHelper;
use Square\ConfigurationInterface;
use Square\Http\ApiResponse;
use Square\Http\HttpRequest;
use Square\Http\HttpResponse;
use Square\Http\HttpMethod;
use Square\Http\HttpContext;
use Square\Http\HttpCallBack;
use Unirest\Request;

class LoyaltyApi extends BaseApi
{
    public function __construct(ConfigurationInterface $config, ?HttpCallBack $httpCallBack = null)
    {
        parent::__construct($config, $httpCallBack);
    }

    /**
     * Creates a loyalty account. For more information, see
     * [Create a loyalty account](https://developer.squareup.com/docs/docs/loyalty-api/overview/#loyalty-
     * overview-create-account).
     *
     * @param \Square\Models\CreateLoyaltyAccountRequest $body An object containing the fields to
     *                                                         POST for the request.
     *
     *                                                         See the corresponding object
     *                                                         definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function createLoyaltyAccount(\Square\Models\CreateLoyaltyAccountRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/accounts';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\CreateLoyaltyAccountResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Searches for loyalty accounts.
     * In the current implementation, you can search for a loyalty account using the phone number
     * associated with the account.
     * If no phone number is provided, all loyalty accounts are returned.
     *
     * @param \Square\Models\SearchLoyaltyAccountsRequest $body An object containing the fields to
     *                                                          POST for the request.
     *
     *                                                          See the corresponding object
     *                                                          definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function searchLoyaltyAccounts(\Square\Models\SearchLoyaltyAccountsRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/accounts/search';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\SearchLoyaltyAccountsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Retrieves a loyalty account.
     *
     * @param string $accountId The ID of the [loyalty account](#type-LoyaltyAccount) to retrieve.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function retrieveLoyaltyAccount(string $accountId): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/accounts/{account_id}';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'account_id' => $accountId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::get($_queryUrl, $_headers);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\RetrieveLoyaltyAccountResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Adds points to a loyalty account.
     *
     * - If you are using the Orders API to manage orders, you only provide the `order_id`.
     * The endpoint reads the order to compute points to add to the buyer's account.
     * - If you are not using the Orders API to manage orders,
     * you first perform a client-side computation to compute the points.
     * For spend-based and visit-based programs, you can call
     * `CalculateLoyaltyPoints` to compute the points. For more information,
     * see [Loyalty Program Overview](https://developer.squareup.com/docs/docs/loyalty/overview).
     * You then provide the points in a request to this endpoint.
     *
     * For more information, see [Accumulate points](https://developer.squareup.com/docs/docs/loyalty-
     * api/overview/#accumulate-points).
     *
     * @param string $accountId The [loyalty account](#type-LoyaltyAccount) ID to which to add the
     *                          points.
     * @param \Square\Models\AccumulateLoyaltyPointsRequest $body An object containing the fields
     *                                                            to POST for the request.
     *
     *                                                            See the corresponding object
     *                                                            definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function accumulateLoyaltyPoints(
        string $accountId,
        \Square\Models\AccumulateLoyaltyPointsRequest $body
    ): ApiResponse {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/accounts/{account_id}/accumulate';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'account_id' => $accountId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\AccumulateLoyaltyPointsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Adds points to or subtracts points from a buyer's account.
     *
     * Use this endpoint only when you need to manually adjust points. Otherwise, in your application flow,
     * you call
     * [AccumulateLoyaltyPoints](https://developer.squareup.com/docs/reference/square/loyalty-
     * api/accumulate-loyalty-points)
     * to add points when a buyer pays for the purchase.
     *
     * @param string $accountId The ID of the [loyalty account](#type-LoyaltyAccount) in which to
     *                          adjust the points.
     * @param \Square\Models\AdjustLoyaltyPointsRequest $body An object containing the fields to
     *                                                        POST for the request.
     *
     *                                                        See the corresponding object
     *                                                        definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function adjustLoyaltyPoints(string $accountId, \Square\Models\AdjustLoyaltyPointsRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/accounts/{account_id}/adjust';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'account_id' => $accountId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\AdjustLoyaltyPointsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Searches for loyalty events.
     *
     * A Square loyalty program maintains a ledger of events that occur during the lifetime of a
     * buyer's loyalty account. Each change in the point balance
     * (for example, points earned, points redeemed, and points expired) is
     * recorded in the ledger. Using this endpoint, you can search the ledger for events.
     * For more information, see
     * [Loyalty events](https://developer.squareup.com/docs/docs/loyalty-api/overview/#loyalty-events).
     *
     * @param \Square\Models\SearchLoyaltyEventsRequest $body An object containing the fields to
     *                                                        POST for the request.
     *
     *                                                        See the corresponding object
     *                                                        definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function searchLoyaltyEvents(\Square\Models\SearchLoyaltyEventsRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/events/search';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\SearchLoyaltyEventsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Returns a list of loyalty programs in the seller's account.
     * Currently, a seller can only have one loyalty program. For more information, see
     * [Loyalty Overview](https://developer.squareup.com/docs/docs/loyalty/overview).
     * .
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function listLoyaltyPrograms(): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/programs';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::get($_queryUrl, $_headers);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\ListLoyaltyProgramsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Calculates the points a purchase earns.
     *
     * - If you are using the Orders API to manage orders, you provide `order_id` in the request. The
     * endpoint calculates the points by reading the order.
     * - If you are not using the Orders API to manage orders, you provide the purchase amount in
     * the request for the endpoint to calculate the points.
     *
     * An application might call this endpoint to show the points that a buyer can earn with the
     * specific purchase.
     *
     * @param string $programId The [loyalty program](#type-LoyaltyProgram) ID, which defines the
     *                          rules for accruing points.
     * @param \Square\Models\CalculateLoyaltyPointsRequest $body An object containing the fields
     *                                                           to POST for the request.
     *
     *                                                           See the corresponding object
     *                                                           definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function calculateLoyaltyPoints(
        string $programId,
        \Square\Models\CalculateLoyaltyPointsRequest $body
    ): ApiResponse {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/programs/{program_id}/calculate';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'program_id' => $programId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\CalculateLoyaltyPointsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Creates a loyalty reward. In the process, the endpoint does following:
     *
     * - Uses the `reward_tier_id` in the request to determine the number of points
     * to lock for this reward.
     * - If the request includes `order_id`, it adds the reward and related discount to the order.
     *
     * After a reward is created, the points are locked and
     * not available for the buyer to redeem another reward.
     * For more information, see
     * [Loyalty rewards](https://developer.squareup.com/docs/docs/loyalty-api/overview/#loyalty-overview-
     * loyalty-rewards).
     *
     * @param \Square\Models\CreateLoyaltyRewardRequest $body An object containing the fields to
     *                                                        POST for the request.
     *
     *                                                        See the corresponding object
     *                                                        definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function createLoyaltyReward(\Square\Models\CreateLoyaltyRewardRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/rewards';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\CreateLoyaltyRewardResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Searches for loyalty rewards in a loyalty account.
     *
     * In the current implementation, the endpoint supports search by the reward `status`.
     *
     * If you know a reward ID, use the
     * [RetrieveLoyaltyReward](https://developer.squareup.com/docs/reference/square/loyalty-api/retrieve-
     * loyalty-reward) endpoint.
     *
     * For more information about loyalty rewards, see
     * [Loyalty Rewards](https://developer.squareup.com/docs/docs/loyalty-api/overview/#loyalty-rewards).
     *
     * @param \Square\Models\SearchLoyaltyRewardsRequest $body An object containing the fields to
     *                                                         POST for the request.
     *
     *                                                         See the corresponding object
     *                                                         definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function searchLoyaltyRewards(\Square\Models\SearchLoyaltyRewardsRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/rewards/search';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\SearchLoyaltyRewardsResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Deletes a loyalty reward by doing the following:
     *
     * - Returns the loyalty points back to the loyalty account.
     * - If an order ID was specified when the reward was created
     * (see [CreateLoyaltyReward](https://developer.squareup.com/docs/reference/square/loyalty-api/create-
     * loyalty-reward)),
     * it updates the order by removing the reward and related
     * discounts.
     *
     * You cannot delete a reward that has reached the terminal state (REDEEMED).
     * For more information, see
     * [Loyalty rewards](https://developer.squareup.com/docs/docs/loyalty-api/overview/#loyalty-overview-
     * loyalty-rewards).
     *
     * @param string $rewardId The ID of the [loyalty reward](#type-LoyaltyReward) to delete.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function deleteLoyaltyReward(string $rewardId): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/rewards/{reward_id}';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'reward_id' => $rewardId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        $_httpRequest = new HttpRequest(HttpMethod::DELETE, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::delete($_queryUrl, $_headers);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\DeleteLoyaltyRewardResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Retrieves a loyalty reward.
     *
     * @param string $rewardId The ID of the [loyalty reward](#type-LoyaltyReward) to retrieve.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function retrieveLoyaltyReward(string $rewardId): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/rewards/{reward_id}';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'reward_id' => $rewardId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::get($_queryUrl, $_headers);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\RetrieveLoyaltyRewardResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }

    /**
     * Redeems a loyalty reward.
     *
     * The endpoint sets the reward to the terminal state (`REDEEMED`).
     *
     * If you are using your own order processing system (not using the
     * Orders API), you call this endpoint after the buyer paid for the
     * purchase.
     *
     * After the reward reaches the terminal state, it cannot be deleted.
     * In other words, points used for the reward cannot be returned
     * to the account.
     *
     * For more information, see
     * [Loyalty rewards](https://developer.squareup.com/docs/docs/loyalty-api/overview/#loyalty-overview-
     * loyalty-rewards).
     *
     * @param string $rewardId The ID of the [loyalty reward](#type-LoyaltyReward) to redeem.
     * @param \Square\Models\RedeemLoyaltyRewardRequest $body An object containing the fields to
     *                                                        POST for the request.
     *
     *                                                        See the corresponding object
     *                                                        definition for field details.
     *
     * @return ApiResponse Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function redeemLoyaltyReward(string $rewardId, \Square\Models\RedeemLoyaltyRewardRequest $body): ApiResponse
    {
        //prepare query string for API call
        $_queryBuilder = '/v2/loyalty/rewards/{reward_id}/redeem';

        //process optional query parameters
        $_queryBuilder = ApiHelper::appendUrlWithTemplateParameters($_queryBuilder, [
            'reward_id' => $rewardId,
            ]);

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri() . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseApi::USER_AGENT,
            'Square-Version' => $this->config->getSquareVersion(),
            'Accept'        => 'application/json',
            'content-type'  => 'application/json',
            'Authorization' => sprintf('Bearer %1$s', $this->config->getAccessToken())
        ];
        $_headers = ApiHelper::mergeHeaders($_headers, $this->config->getAdditionalHeaders());

        //json encode body
        $_bodyJson = Request\Body::Json($body);

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, $_bodyJson);
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        if (!$this->isValidResponse($_httpResponse)) {
            return ApiResponse::createFromContext($response->body, null, $_httpContext);
        }

        $mapper = $this->getJsonMapper();
        $deserializedResponse = $mapper->mapClass($response->body, 'Square\\Models\\RedeemLoyaltyRewardResponse');
        return ApiResponse::createFromContext($response->body, $deserializedResponse, $_httpContext);
    }
}
