<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Date
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Date extends Input
{

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType('text');
        $this->addClass('date');
    }
}
