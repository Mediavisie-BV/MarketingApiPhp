<?php

namespace MediavisieBv\MarketingApi;

use GuzzleHttp\Client;

class MarketingRequests
{
    private $_apiToken;
    private $_guzzleConfigKeys;

    public function __construct(string $apiToken, array $guzzleConfigKeys = [])
    {
        $this->_apiToken = $apiToken;
        $this->_guzzleConfigKeys = $guzzleConfigKeys;
    }

    /**
     * @param string $endpoint
     * @param null $data
     * @param string $method
     * @return \stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function executeRequest(string $endpoint, $data = null, string $method = 'GET') : \stdClass
    {
        // guzzle request
        $client = new Client($this->_guzzleConfigKeys);

        // build headers
        $headers = $this->_buildHeaders();

        $options = [
            'headers' => $headers
        ];
        if($method === 'POST' || $method === 'PUT') {
            $options['body'] = json_encode($data);
        }

        try {
            $response = $client->request($method, $endpoint, $options);
        } catch (\Exception $e) {
            $response = new \stdClass();
            $response->error = true;
            $response->message = $e->getMessage();
            $response->code = $e->getCode();
            return $response;
        }

        if($response->getStatusCode() >= 300) {
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
