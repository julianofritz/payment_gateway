<?php

namespace Gateway;

use Gateway\Gateway\Cielo;
use Gateway\Gateway\Gateway;
use Gateway\Gateway\IGateway;
use PHPUnit\Framework\TestCase;
use Gateway\Gateway\LoadGateway;
use Gateway\Gateway\MaxiPago;
use Gateway\Gateway\Rede;

class LoadGatewayTest extends TestCase
{
    public function testInstanceLoadGateway()
    {
        $gateway = new LoadGateway(); 
        
        $this->assertInstanceOf(LoadGateway::class, $gateway);
    }

    public function testLoadRedeGateway()
    {
        $gateway = new LoadGateway;
        $rede = new Rede;

        $gateway->load($rede);


        $this->assertInstanceOf(IGateway::class, $gateway->getGateway());
    }

    public function testLoadCieloGateway()
    {
        $gateway = new LoadGateway;
        $cielo = new Cielo;

        $gateway->load($cielo);

        $this->assertInstanceOf(IGateway::class, $gateway->getGateway());
    }

    public function testLoadMaxiPagoGateway()
    {
        $gateway =  new LoadGateway;
        $maxiPago = new MaxiPago;

        $gateway->load($maxiPago);
        
        $this->assertInstanceOf(IGateway::class, $gateway->getGateway());
    }

}