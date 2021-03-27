<?php

namespace Gateway\Gateway;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class Gateway implements IGateway
{
    /**
     * @var SendTransaction
     */
    protected $sendTransaction;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $httpMethod;

    /**
     * @var array
     */
    protected $payment;

    /**
     * @var array;
     */
    protected $request;

    public function __construct()
    {
        $this->sendTransaction = new SendTransaction();
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    public function setHttpMethod(string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    public function setPayment(array $payment)
    {
        $this->payment = $payment;
    }

    public function config()
    {
        
    }

    public function authorize()
    {
        $this->sendTransaction->setUri($this->uri);
        $this->sendTransaction->setRoute($this->route);
        $this->sendTransaction->setHttpMethod($this->httpMethod);
        $this->sendTransaction->setRequest($this->request);
        return $this->sendTransaction->send();
    }

    public function mountBody()
    {
        
    }

    public function mountHeader()
    {
        
    }

    public function pay()
    {

    }
}