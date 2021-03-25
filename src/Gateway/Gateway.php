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
     * @var array
     */
    protected $payment;

    public function __construct()
    {
        $this->sendTransaction = new SendTransaction();
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
        try {
            $request = $this->config();

            $this->sendTransaction->send();
        } catch (GuzzleException  $e) {
            throw new GuzzleException($e->getResponse()->getBody()->getContents());
        }

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