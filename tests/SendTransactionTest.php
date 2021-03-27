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
        'reference'             => 123,
        'amount'            => 2250,
        'installments'      => 1,
        'cardNumber'        => 5448280000000007,
        'cardHolder'        => 'User Test',
        'expirationMonth'   => 12,
        'expirationYear'    => 21,
        'securityCode'      => 123,
        'softDescriptor'    => 'Test Gateway'
    ];

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $httpMthod;

    /**
     * @var array
     */
    private $request;

    public function testInstanceSendTransaction()
    {
        $sendTransaction = new SendTransaction; 
        
        $this->assertInstanceOf(Transaction::class, $sendTransaction);
    }

    public function testSendCreditRedeRequestWithInvalidCardNumber(): void
    {
        $this->setRandomOrder();
        $this->cardData['cardNumber'] = '4111111111111111';
        $this->mountRedeRequest();

        $sendTransaction = new SendTransaction();
        $sendTransaction->setUri($this->uri);
        $sendTransaction->setRoute($this->route);
        $sendTransaction->setHttpMethod('POST');
        $sendTransaction->setRequest($this->request);

        $this->expectException('GuzzleHttp\Exception\ClientException');

        $sendTransaction->send();
    }

    public function testSendValidCreditRedeRequest(): void
    {
        $this->setRandomOrder();
        $this->mountRedeRequest();

        $sendTransaction = new SendTransaction();
        $sendTransaction->setUri($this->uri);
        $sendTransaction->setRoute($this->route);
        $sendTransaction->setHttpMethod('POST');
        $sendTransaction->setRequest($this->request);

        $response = $sendTransaction->send();
        $decodedResponse = json_decode($response->getBody()->getContents());

        $this->assertEquals('00', $decodedResponse->returnCode);
        $this->assertEquals('Success.', $decodedResponse->returnMessage);
    }

    private function setRandomOrder()
    {
        $this->cardData['reference'] = rand(1,50000);
    }

    private function mountRedeRequest():void
    {
        $authToken = base64_encode(Rede::REDE_PV . ':' . Rede::REDE_TOKEN);

        $this->uri = Rede::REDE_URI;
        $this->route = '/desenvolvedores/v1/transactions';
        $this->request = [
            'headers' => [
                'Authorization' => 'Basic '. $authToken,
                'content-type' => 'application/json'
            ],
            'json' => $this->cardData
        ];
    }

}