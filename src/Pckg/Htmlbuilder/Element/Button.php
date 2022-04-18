<?php

namespace Pckg\Htmlbuilder\Element;

/**
 * Class Button
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Button extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setType('button');
        $this->setAttribute("value", "Button");
    }
}
