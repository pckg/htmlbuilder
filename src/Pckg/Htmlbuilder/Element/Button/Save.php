<?php

namespace Pckg\Htmlbuilder\Element\Button;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Save
 *
 * @package Pckg\Htmlbuilder\Element\Button
 */
class Save extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setType("submit");
        $this->setAttribute("name", "save");
        $this->setValue("Save");
    }
}
