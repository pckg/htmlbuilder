<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Email
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Email extends Input
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("email");
    }
}