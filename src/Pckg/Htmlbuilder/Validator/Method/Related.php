<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Related
 *
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Related extends AbstractValidator
{
    /**
     * @param Element $element
     *
     * @return mixed
     */
    public function matchesField(callable $next, Element $element, $args)
    {
        return $next();
    }
}
