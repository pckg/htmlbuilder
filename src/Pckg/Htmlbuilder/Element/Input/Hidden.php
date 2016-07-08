<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Hidden
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Hidden extends Input
{

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("hidden");
    }
}