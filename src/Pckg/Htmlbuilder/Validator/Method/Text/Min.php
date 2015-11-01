<?php

namespace Pckg\Htmlbuilder\Validator\Method\Text;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;
use Pckg\Concept\AbstractObject;

/**
 * Class Min
 * @package Pckg\Htmlbuilder\Validator\Method\Text
 */
class Min extends AbstractValidator
{

    /**
     * @var string
     */
    protected $msg = 'Field {field} should be min {min} characters long.';

    /**
     * @var int
     */
    protected $min = 0;

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadMin(callable $next, AbstractObject $context)
    {
        $this->min = $context->getArg(0);

        return $next();
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return mb_strlen($value) >= $this->min;
    }

    /**
     * @param Element $element
     */
    public function getAngularJSValidator(Element $element)
    {
        //return $element->getAttribute('ng-model') . '.length > 0';
    }

}