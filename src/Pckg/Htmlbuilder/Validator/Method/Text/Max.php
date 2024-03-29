<?php

namespace Pckg\Htmlbuilder\Validator\Method\Text;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Max
 *
 * @package Pckg\Htmlbuilder\Validator\Method\Text
 */
class Max extends AbstractValidator
{
    /**
     * @var string
     */
    protected $msg = 'Field should be max {max} characters long.';

    /**
     * @var int
     */
    protected $max = 1337;

    /**
     * @var array
     */
    protected $methods = ['max', 'isValid', 'getErrorMessages'];

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadMax(callable $next, AbstractObject $context)
    {
        $this->max = $context->getArg(0);
        $this->setEnabled();

        return $next();
    }

    /**
     * @return bool
     */
    public function validate($value)
    {
        return mb_strlen($value) <= $this->max;
    }

    /**
     * @param Element $element
     */
    public function getAngularJSValidator(Element $element)
    {
        //return "true";
        //return 'formBaseRoute[\'' . $element->getAttribute('name') . '\'].$error.viewValue <= ' . $this->max;
    }

    /**
     * @return string|string[]
     */
    public function getMsg()
    {
        return str_replace('{max}', $this->max, parent::getMsg());
    }
}
