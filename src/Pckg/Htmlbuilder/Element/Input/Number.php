<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Number
 *
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Number extends Input
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setType("number");
    }

    public function setValue($value = null)
    {
        if (is_null($value)) {
            return parent::setValue($value);
        }
        if (static::class == Number::class) {
            return parent::setValue(number_format($value, 0));
        }
        if (static::class == Input\Number\Decimal::class) {
            return parent::setValue(number_format($value, 2, '.', ''));
        }
        return parent::setValue($value);
    }

}