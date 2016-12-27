<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Text
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Geo extends Point
{

    public function __construct()
    {
        parent::__construct();

        $this->addClass('geo');
    }

}