<?php

namespace Gateway;


use Gateway\Validators\CardRequest;
use PHPUnit\Framework\TestCase;

class CardRequestTest extends TestCase
{
    /**
     * @var CardRequest;
     */
    private $cardRequest;

    private $requestData = [
        'reference' => 123,
        'amount' => 2250,
        'installments' => 1,
        'cardNumber' => 5448280000000007,
        'cardHolder' => 'User Test',
        'expirationMonth' => 12,
        'expirationYear' => 21,
        'securityCode' => 123,
        'softDescriptor' => 'Test Gateway'
    ];

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->cardRequest = new CardRequest();

        $this->cardRequest->setRequest($this->requestData);

        parent::__construct($name, $data, $dataName);
    }

    public function testInstanceCardRequest()
    {
        $this->assertInstanceOf(CardRequest::class, $this->cardRequest);
    }

    public function testValidCard()
    {
        $response = $this->cardRequest->validate();

        $this->assertTrue($response);
    }

    public function testInvalidCardNumber()
    {
        $this->requestData['cardNumber'] = 123;
        $this->cardRequest->setRequest($this->requestData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid card number');

        $this->cardRequest->validate();
    }

    public function testInvalidHolderName()
    {
        $this->requestData['cardHolder'] = 'ab';
        $this->cardRequest->setRequest($this->requestData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid holder name');

        $this->cardRequest->validate();
    }

    public function testExpiratedMonth()
    {
        $this->requestData['expirationMonth'] = 01;
        $this->requestData['expirationYear'] = 21;
        $this->cardRequest->setRequest($this->requestData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid month - expirated');

        $this->cardRequest->validate();
    }

    public function testOutOfRangeMonth()
    {
        $this->requestData['expirationMonth'] = 16;
        $this->cardRequest->setRequest($this->requestData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid month - must have between 1 and 12');

        $this->cardRequest->validate();
    }

    public function testExpiratedYear()
    {
        $this->requestData['expirationYear'] = 20;
        $this->cardRequest->setRequest($this->requestData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid year - expirated');

        $this->cardRequest->validate();
    }

}