<?php

namespace  App\Traits;

use GuzzleHttp\Client;

trait ConsumeExternalServices
{

    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [])
    {
        //code...
        $client = new Client([
            'base_uri' => $this->baseUri,
            'auth' => [$this->userKey, ''],
            'verify' => false
        ]);
        if (method_exists($this, 'resolveAuthorization')) {
            $this->resolveAuthorization($queryParams, $formParams, $headers);
        }

        $response = $client->request($method, $requestUrl, [
            'query' => $queryParams,
            'form_params' => $formParams,
            'headers' => $headers,
            'timeout' => 55
        ]);
        $response = $response->getBody()->getContents();

        if (method_exists($this, 'decodeResponse')) {
            $response = $this->decodeResponse($response);
        }

        if (method_exists($this, 'checkIfErrorResponse')) {
            $this->checkIfErrorResponse($response);
        }
        return $response;
    }
}
