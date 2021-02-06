<?php

namespace Pckg\Htmlbuilder\Element\Button;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Submit
 *
 * @package Pckg\Htmlbuilder\Element\Button
 */
class Submit extends Input
{

    /**
     * @var bool
     */
    protected $validatable = false;

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("submit");
        $this->setAttribute("value", __('btn.submit'));
        $this->setAttribute("name", "submit");
    }
}
