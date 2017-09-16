<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/17/17
 * Time: 12:52 AM
 */

namespace AppBundle\Service\Helper;


class ParameterContainer
{
    protected $appParameters;

    public function __construct($appParameters = [])
    {
        $this->appParameters = $appParameters;
    }

    public function getAppParameters()
    {

        return $this->appParameters;
    }
}