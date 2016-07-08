<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Csrf
 *
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Csrf extends AbstractValidator
{

    /**
     * @var bool
     */
    protected $recursive = false;

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        if (in_array($element->getTag(), ['form'])) {
            //$fieldset = $element->addFieldset()->setClass('crsf');
            //$csrf = $fieldset->addField(new Element\Input\Hidden\Csrf());

            // save csrf value to session
        }

        return $next();
    }
}