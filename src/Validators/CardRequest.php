<?php

namespace Gateway\Validators;


class CardRequest
{
    /**
     * array
     */
    private $request;

    public function setRequest(array $request)
    {
        $this->request = $request;
    }

    public function validate(): bool
    {
        try {
            $this->cardNumber();
            $this->cardHolder();

            return true;
        }  catch (\Exception $e) {
            throw $e;
        }
    }

    private function cardNumber(): bool
    {
        if (strlen($this->request['cardNumber']) != 16) {
            throw new \Exception('Invalid card number');
        }

        return true;
    }

    private function cardHolder(): bool
    {
        if (strlen($this->request['cardHolder']) <  3) {
            throw new \Exception('Invalid holder name');
        }

        return true;
    }

}