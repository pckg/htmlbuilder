<?php

namespace Pckg\Htmlbuilder\Validator\Method\Common;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;
use Pckg\Concept\AbstractObject;

/**
 * Class Unique
 * @package Pckg\Htmlbuilder\Validator\Method\Common
 */
class Unique extends AbstractValidator
{

    /**
     * @var string
     */
    protected $msg = 'Field should be unique';

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadUnique(callable $next, AbstractObject $context)
    {
        return $next();
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return true;
    }

    /**
     * @param Element $element
     */
    public function getAngularJSValidator(Element $element)
    {
        //return "true";
        //return 'formBaseRoute[\'' . $element->getAttribute('name') . '\'].$error.required';
    }

}