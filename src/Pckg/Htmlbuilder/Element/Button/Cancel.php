<?php

namespace Pckg\Htmlbuilder\Element\Button;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Cancel
 *
 * @package Pckg\Htmlbuilder\Element\Button
 */
class Cancel extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setType("reset");
        $this->setAttribute("value", "Cancel");
    }
}
