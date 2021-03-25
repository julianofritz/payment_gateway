<?php

namespace Gateway\Gateway;

interface IGateway 
{
    function setPayment(array $payment);

    function config();
    
    function authorize();

    function mountBody();

    function mountHeader();

    function pay();
}