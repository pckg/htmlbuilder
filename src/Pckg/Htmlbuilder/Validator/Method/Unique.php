<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Unique
 *
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
     *
     * @return mixed
     */
    public function unique(callable $next, Element $element, $args)
    {
        $this->isUnique = true;

        return $next();
    }

    /**
     * @return bool
     */
    public function validate($value)
    {
        return !!$value;
    }
}
