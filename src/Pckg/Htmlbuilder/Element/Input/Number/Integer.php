<?php

namespace Pckg\Htmlbuilder\Element\Input\Number;

use Pckg\Htmlbuilder\Element\Input\Number;

/**
 * Class Int
 *
 * @package Pckg\Htmlbuilder\Element\Input\Number
 * @method setStep(int|float|null $step)
 */
class Integer extends Number
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setStep(1);
    }
}
