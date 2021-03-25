<?php

namespace Gateway\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class SendTransaction implements Transaction
{
    /**
     * @var array
     */
    private $request;

    /**
     * @var  string
     */
    private $uri;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $httpMethod;

    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    public function setHttpMethod(string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    public function send()
    {
        $client = new Client([
            'base_uri' => $this->uri,
            'verify' => false,
        ]);
        
        return $client->request($this->httpMethod, $this->route, $this->request);        
    }

}