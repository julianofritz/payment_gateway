<?php

namespace Gateway\Gateway;


class LoadGateway
{
    /**
     * @var IGateway
     */
    private $gateway;

    public function getGateway(): IGateway
    {
        return $this->gateway;
    }

    public function load(IGateway $gateway)
    {
        $this->gateway = $gateway;
    }

}