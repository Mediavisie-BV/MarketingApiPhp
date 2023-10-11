<?php

namespace MediavisieBv\MarketingApi;

use MediavisieBv\MarketingApi\Traits\SubscriptionsTrait;

class MarketingApi
{
    use SubscriptionsTrait;

    private string $_apiEndpoint;
    private string $_apiToken;

    private ?array $_guzzleConfigKeys = null;

    public function __construct(string $apiEndpoint, string $apiToken)
    {
        // normalize the enpoint url
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

    public function setConfigKeys(string $key, mixed $value): void
    {
        $this->_guzzleConfigKeys[$key] = $value;
    }

    /**
     * @throws \Exception
     */
    public function getData(string $endpoint, ?array $data = null)
    {
        $request = new MarketingRequests($this->_getApiToken(), $this->_guzzleConfigKeys);
        try {
            // strip leading slash from the given endpoint
            return $request->getData($this->_getApiEndpoint(ltrim($endpoint, '/')), $data);
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
