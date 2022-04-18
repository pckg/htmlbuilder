<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Time
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Time extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->addClass("time");
    }
}
