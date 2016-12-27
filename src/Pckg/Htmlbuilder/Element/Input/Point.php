<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Text
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Point extends Input
{

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("text");

        $this->addClass('point');
    }
}