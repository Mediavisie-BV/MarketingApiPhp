<?php

namespace MediavisieBv\MarketingApi;

use GuzzleHttp\Client;

class MarketingRequests
{
    private string $_apiToken;
    private array $_guzzleConfigKeys;

    public function __construct(string $apiToken, array $guzzleConfigKeys = [])
    {
        $this->_apiToken = $apiToken;
        $this->_guzzleConfigKeys = $guzzleConfigKeys;
    }

    /**
     * @param string $endpoint
     * @param array|null $data
     * @return string
     * @throws \Exception
     */
    public function getData(string $endpoint, ?array $data = null) : \stdClass
    {
        // guzzle request
        $client = new Client($this->_guzzleConfigKeys);

        // build headers
        $headers = $this->_buildHeaders();

        $method = empty($data) ? 'GET' : 'POST';
        $response = $client->request($method, $endpoint, ['headers' => $headers]);

        if($response->getStatusCode() !== 200) {
            throw new \Exception('Error: ' . $response->getStatusCode());
        }

        // check if we get a json return
        $contentType = $response->getHeaderLine('content-type');

        if(!str_contains($contentType, 'application/json')) {
            throw new \Exception('Error: No JSON response');
        }

        return json_decode($response->getBody()->getContents());
    }

    private function _buildHeaders(): array
    {
        $headers = [];
        if(!empty($this->_apiToken)) {
            $headers['X-API-KEY'] = $this->_apiToken;
        }
        return $headers + [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
}
