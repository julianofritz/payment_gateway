<?php

namespace Gateway;

use Gateway\Gateway\Rede;
use Gateway\Gateway\SendTransaction;
use Gateway\Gateway\Transaction;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

class SendTransactionTest extends TestCase
{
    public function testInstanceSendTransaction()
    {
        $sendTransaction = new SendTransaction; 
        
        $this->assertInstanceOf(Transaction::class, $sendTransaction);
    }

    public function testSendCreditRedeRequestWithInvalidCredentials(): void
    {
        $rede = new Rede;
        $rede->setPayment($this->getPaymentArray());
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