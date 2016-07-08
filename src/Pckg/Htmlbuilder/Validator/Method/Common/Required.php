<?php

namespace Pckg\Htmlbuilder\Validator\Method\Common;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Required
 *
 * @package Pckg\Htmlbuilder\Validator\Method\Common
 */
class Required extends AbstractValidator
{

    /**
     * @var string
     */
    protected $msg = 'Field is required';

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['required'];
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadRequired(callable $next, AbstractObject $context)
    {
        $context->getElement()->emptyAttribute('required');

        $this->setEnabled();

        return $next();
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function validate($value)
    {
        return strlen($value) > 0;
    }

    /**
     * @param Element $element
     *
     * @return string
     */
    public function getAngularJSValidator(Element $element)
    {
        $name = $element->getAttribute('name');
        $form = $element->closest('form');

        $formName = $form
            ? $form->getName()
            : 'form' . ucfirst(substr($name, 0, strpos($name, '[')));

        return $formName . '[\'' . $name . '\'].$error.required';
    }

}