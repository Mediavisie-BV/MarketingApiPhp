<?php

namespace MediavisieBv\MarketingApi;

use MediavisieBv\MarketingApi\Models\Responses\MessageResponse;
use MediavisieBv\MarketingApi\Traits\AttributesTrait;
use MediavisieBv\MarketingApi\Traits\SubscriptionsTrait;

class MarketingApi
{
    use SubscriptionsTrait, AttributesTrait;

    private $_apiEndpoint;
    private $_apiToken;

    private $_guzzleConfigKeys = null;

    /**
     * @param string $apiEndpoint
     * @param string $apiToken
     * @throws \Exception
     */
    public function __construct(string $apiEndpoint, string $apiToken)
    {
        // normalize the endpoint url
        if (!str_ends_with($apiEndpoint, '/')) {
            $apiEndpoint .= '/';
        }

        // check if the given url is correct
        if (!filter_var($apiEndpoint, FILTER_VALIDATE_URL)) {
            throw new \Exception('The given api endpoint is not a valid url');
        }

        $this->_apiEndpoint = $apiEndpoint;
        $this->_apiToken = $apiToken;
    }

    public function setConfigKeys(string $key, $value): void
    {
        $this->_guzzleConfigKeys[$key] = $value;
    }

    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getData(string $endpoint, ?array $data = null, $method="GET")
    {
        $request = new MarketingRequests($this->_getApiToken(), (array)$this->_guzzleConfigKeys);
        try {
            // strip leading slash from the given endpoint
            return $request->executeRequest($this->_getApiEndpoint(ltrim($endpoint, '/')), $data, $method);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function executeRequest(string $endpoint, $method, $data = null)
    {
        $request = new MarketingRequests($this->_getApiToken(), (array)$this->_guzzleConfigKeys);
        try {
            // strip leading slash from the given endpoint
            return $request->executeRequest($this->_getApiEndpoint(ltrim($endpoint, '/')), $data, $method);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function _getApiToken(): string
    {
        return $this->_apiToken;
    }

    /**
     * @throws \Exception
     */
    private function _getApiEndpoint(string $postEndpoint): string
    {
        $endpoint = $this->_apiEndpoint . $postEndpoint;

        // check if endpoint is a valid url
        if (!filter_var($endpoint, FILTER_VALIDATE_URL)) {
            throw new \Exception('The given api endpoint is not a valid url');
        }

        return $endpoint;
    }
}
