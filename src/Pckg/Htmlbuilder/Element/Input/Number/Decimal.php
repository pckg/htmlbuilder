<?php

namespace Pckg\Htmlbuilder\Element\Input\Number;

use Pckg\Htmlbuilder\Element\Input\Number;

/**
 * Class Float
 *
 * @package Pckg\Htmlbuilder\Element\Input\Number
 */
class Decimal extends Number
{

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setAttribute('step', '0.01');
    }
}
