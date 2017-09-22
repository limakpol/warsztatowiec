<?php

namespace HeaderBundle\Service\Helper;

use Symfony\Component\HttpFoundation\RequestStack;

class General
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }


}