<?php

namespace Gateway\Gateway;


class Rede extends Gateway
{
    const REDE_KEY = 'rede_key';

    const REDE_SECRET = 'rede_secret'; 

    const REDE_URI = 'https://api.userede.com.br';

    const REDE_CREDIT_REQUEST = 'credit';

    public function mountHeader(): array
    {
        $authToken = base64_encode(self::REDE_KEY . ':' . self::REDE_SECRET);

        return [
            'Authorization' => 'Basic '. $authToken,
            'content-type' => 'application/json'
        ];
    }

    public function mountBody(): array
    {
        return [
            'capture'           => true,
            'kind'              => self::REDE_CREDIT_REQUEST,
            'reference'         => $this->payment['order'],
            'amount'            => $this->payment['amount'],
            'installments'      => $this->payment['installments'],
            'cardNumber'        => $this->payment['cardNumber'],
            'cardHolderName'    => substr($this->payment['cardHolder'], 0,29),
            'expirationMonth'   => $this->payment['expirationMonth'],
            'expirationYear'    => $this->payment['expirationYear'],
            'securityCode'      => $this->payment['securityCode'],
            'softDescriptor'    => $this->payment['softDescriptor'],
        ];
    }

    public function config(): array
    {
        return [
           'headers' => $this->mountHeader(),
           'json' => $this->mountBody()
        ];
    }
    
}