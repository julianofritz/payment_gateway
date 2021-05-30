<?php

namespace Gateway;

use Gateway\Gateway\Rede;
use Gateway\Gateway\SendTransaction;
use Gateway\Gateway\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class SendTransactionTest extends TestCase
{
    /**
     * @var array
     */
    private $cardData = [
        'reference'         => 123,
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

    /**
     * @var SendTransaction
     */
    private $sendTransaction;

    /**
     * @var Client
     */
    private $client;

    public function setUp(): void
    {
        $this->client = \Mockery::mock(Client::class);
        $this->sendTransaction =  new SendTransaction($this->client);
    }

    public function testInstanceSendTransaction()
    {
        $this->assertInstanceOf(Transaction::class, $this->sendTransaction);
    }

    public function testSendCreditRedeRequestWithInvalidCardNumber(): void
    {
        $clientExcpetion = $this->getMockBuilder(ClientException::class)
            ->disableOriginalConstructor()->getMock();

        $this->client->shouldReceive('pay')
            ->andThrow($clientExcpetion);

        $this->setRandomOrder();
        $this->cardData['cardNumber'] = '4111111111111111';
        $this->mountRedeRequest();

        $this->sendTransaction->setUri($this->uri);
        $this->sendTransaction->setRoute($this->route);
        $this->sendTransaction->setHttpMethod('POST');
        $this->sendTransaction->setRequest($this->request);

        $this->expectException(ClientException::class);

        $this->sendTransaction->send();
    }

   /* public function testSendCreditRedeRequestValid(): void
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
    }*/

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