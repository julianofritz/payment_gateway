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
        $request = $this->config();

        $this->sendTransaction->send();
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