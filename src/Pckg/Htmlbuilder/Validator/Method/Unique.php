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
     * @param         $args
     * @return mixed
     */
    public function unique(callable $next, Element $element, $args)
    {
        $this->isUnique = true;

        return $next();
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return !!$value;
    }
}