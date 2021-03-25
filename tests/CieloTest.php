<?php

namespace Gateway;

use Gateway\Gateway\Cielo;
use PHPUnit\Framework\TestCase;

class CieloTest extends TestCase
{
    public function testInstanceCielo()
    {
        $gateway = new Cielo; 
        
        $this->assertInstanceOf(Cielo::class, $gateway);
    }

}