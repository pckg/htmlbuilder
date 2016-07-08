<?php

namespace Pckg\Htmlbuilder\Element\Input\Number;

use Pckg\Htmlbuilder\Element\Input\Number;

/**
 * Class Int
 *
 * @package Pckg\Htmlbuilder\Element\Input\Number
 */
class Integer extends Number
{

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setStep(1);
    }
}