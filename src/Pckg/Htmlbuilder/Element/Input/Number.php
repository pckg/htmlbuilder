<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Number
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Number extends Input
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("number");
    }
}