<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Validator\AbstractValidator;
use Pckg\Htmlbuilder\Validator\Element;

/**
 * Class Unique
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Unique extends AbstractValidator
{

    /**
     * @var bool
     */
    protected $isUnique = false;

    /**
     * @param Element $element
     * @param $args
     * @return mixed
     */
    public function unique(Element $element, $args)
    {
        $this->isUnique = true;

        return $this->next->unique($element, $args);
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        // @T00D00
        return !!$value;
    }
}