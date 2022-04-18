<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Radio
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Radio extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setType("radio");
    }
}
