<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Related
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Related extends AbstractValidator
{

    /**
     * @param Element $element
     * @param $args
     * @return mixed
     */
    public function matchesField(Element $element, $args)
    {
        return $this->next->matchesField($element, $args);
    }

}