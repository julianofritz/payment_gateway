<?php

namespace Gateway;


use Gateway\Gateway\MaxiPago;
use PHPUnit\Framework\TestCase;

class MaxiPagoTest extends TestCase
{
    public function testInstanceMaxiPago()
    {
        $gateway = new MaxiPago; 
        
        $this->assertInstanceOf(MaxiPago::class, $gateway);
    }

}