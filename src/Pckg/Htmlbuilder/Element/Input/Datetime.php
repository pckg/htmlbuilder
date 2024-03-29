<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Datetime
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Datetime extends Input
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->addClass('datetime');
        $this->setType('text');
    }
}
