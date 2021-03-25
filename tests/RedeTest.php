<?php

namespace Gateway;

use Gateway\Gateway\Rede;
use PHPUnit\Framework\TestCase;

class RedeTest extends TestCase
{
    public function testInstanceRede()
    {
        $gateway = new Rede; 
        
        $this->assertInstanceOf(Rede::class, $gateway);
    }

    public function SendCreditRedeRequestWithInvalidCredentials()
    {
        $rede = new Rede;
        $rede->setPayment($this->getPaymentArray());
        $rede->mountHeader();
        $rede->mountBody();
        $rede->config();
        $rede->authorize();
    }

    private function getPaymentArray(): array
    {
        return [
            'order'             => rand(1, 50000),
            'amount'            => 2250,
            'installments'      => 1,
            'cardNumber'        => 4111111111111111,
            'cardHolder'        => 'User Test',
            'expirationMonth'   => 12,
            'expirationYear'    => 21,
            'securityCode'      => 123,
            'softDescriptor'    => 'Test Gateway',
        ];
    }

}