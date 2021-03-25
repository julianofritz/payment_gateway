<?php

namespace Gateway\Gateway;

interface Transaction
{
    public function setRequest(array $request);

    public function setHttpMethod(string $httpMethod);

    public function setRoute(string $route);

    public function send();
}