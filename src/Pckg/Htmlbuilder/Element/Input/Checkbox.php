<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Checkbox
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Checkbox extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setType("checkbox");
        $this->setValue(1);
    }

    /**
     * @param bool $checked
     *
     * @return $this
     */
    public function setChecked($checked = true)
    {
        if ($checked) {
            $this->setAttribute("checked", "checked");
        } else {
            $this->unsetAttribute("checked");
        }

        return $this;
    }
}
