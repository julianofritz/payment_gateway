<?php

namespace Gateway;

use Gateway\Gateway\Rede;
use Gateway\Gateway\SendTransaction;
use Gateway\Gateway\Transaction;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class SendTransactionTest extends TestCase
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

    public function testInstanceSendTransaction()
    {
        $sendTransaction = new SendTransaction; 
        
        $this->assertInstanceOf(Transaction::class, $sendTransaction);
    }

    public function testSendCreditRedeRequestWithInvalidCardNumber(): void
    {
        $this->setRandomOrder();
        $this->cardData['cardNumber'] = '4111111111111111';

        $rede = new Rede;
        $rede->setPayment($this->cardData);
        $rede->mountHeader();
        $rede->mountBody();
        $request = $rede->config();

        $sendTransaction = new SendTransaction();
        $sendTransaction->setRequest($request);
        $sendTransaction->setHttpMethod('POST');
        $sendTransaction->setUri(Rede::REDE_URI);
        $sendTransaction->setRoute('/desenvolvedores/v1/transactions');

        $this->expectException('GuzzleHttp\Exception\ClientException');

        $sendTransaction->send();
    }

    public function testSendValidCreditRedeRequest(): void
    {
        $this->setRandomOrder();

        $rede = new Rede;
        $rede->setPayment($this->cardData);
        $rede->mountHeader();
        $rede->mountBody();
        $request = $rede->config();

        $sendTransaction = new SendTransaction();
        $sendTransaction->setRequest($request);
        $sendTransaction->setHttpMethod('POST');
        $sendTransaction->setUri(Rede::REDE_URI);
        $sendTransaction->setRoute('/desenvolvedores/v1/transactions');

        $response = $sendTransaction->send();
        $decodedResponse = json_decode($response->getBody()->getContents());

        $this->assertEquals('00', $decodedResponse->returnCode);
    }

    private function setRandomOrder()
    {
        $this->cardData['order'] = rand(1,50000);
    }

}