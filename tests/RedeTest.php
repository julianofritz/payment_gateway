<?php

namespace Gateway;

use Gateway\Gateway\Rede;
use PHPUnit\Framework\TestCase;

class RedeTest extends TestCase
{
    /**
     * @var array
     */
    private $cardData = [
        'order'             => 123,
        'amount'            => 2250,
        'installments'      => 1,
        'cardNumber'        => 5448280000000007,
        'cardHolder'        => 'User Test',
        'expirationMonth'   => 12,
        'expirationYear'    => 21,
        'securityCode'      => 123,
        'softDescriptor'    => 'Test Gateway'
    ];

    public function testInstanceRede()
    {
        $gateway = new Rede; 
        
        $this->assertInstanceOf(Rede::class, $gateway);
    }

    public function testSendCreditRedeRequestValid()
    {
        $this->cardData['order'] = rand(1, 50000);
        $rede = new Rede;
        $rede->setPayment($this->cardData);
        $rede->setHttpMethod('POST');
        $rede->setUri(Rede::REDE_URI);
        $rede->setRoute('/desenvolvedores/v1/transactions');
        $rede->config();
        $response = $rede->authorize();
        $decodedResponse = json_decode($response->getBody()->getContents());

        $this->assertEquals(00, $decodedResponse->returnCode);
        $this->assertEquals('Success.', $decodedResponse->returnMessage);
    }

    public function testSendCreditRedeRequestInvalidCardNumber()
    {
        $this->cardData['cardNumber'] = '4111111111111111';

        $rede = new Rede;
        $rede->setPayment($this->cardData);
        $rede->setHttpMethod('POST');
        $rede->setUri(Rede::REDE_URI);
        $rede->setRoute('/desenvolvedores/v1/transactions');
        $rede->config();

        $this->expectException('GuzzleHttp\Exception\ClientException');
        $rede->authorize();
    }

}