<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;

/*
 * AngularJS is element decorator which adds few AngularJS directives to elements.
 * You can simply bind every element and form to Angular scope.
 *
 * */

/**
 * Class AngularJSValidator
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class AngularJSValidator extends AbstractDecorator
{

    /*
     * User to determine form's and element's name
     * @setter, @chain - setRecord($record)
    */
    /**
     * @var
     */
    protected $record;

    /**
     * @var bool
     */
    protected $recursive = true;

    /*
     * Catches 'setRecord' on element and executes next link/chain.
     * */
    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function setRecord(callable $next, AbstractObject $context)
    {
        $this->record = $context->getArg(0);

        return $next();
    }

    /*
     * Decorator logic
     * */
    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        $this->decorateModel($element);

        return $next();
    }

    /*
     * Takes an element and chooses specific decorating method
     * */
    /**
     * @param $element
     */
    protected function decorateModel($element)
    {
        if ($element->getName()
            && in_array($element->getTag(), ['input', 'select', 'textarea'])
            && !in_array($element->getAttribute('type'), ['submit', 'button', 'hidden'])
        ) {
            $this->setErrorMessages($element);
        }
    }

    /*
     * Binds element to angular object
     * */
    /**
     * @param Element $element
     */
    protected function setErrorMessages(Element $element)
    {
        $arrValidators = $element->getValidators();

        foreach ($arrValidators AS $validator) {
            if (($message = $validator->getMsg())) {
                $messageHolder = $this->elementFactory->create('Div');

                $messageDiv = $this->elementFactory->create('Div');
                $messageDiv->addChild(str_replace('{field}', $element->getName(), $message));
                $messageDiv->setAttribute('ng-show', $validator->getAngularJSValidator($element));
                $messageHolder->addChild($messageDiv);

                $element->addSibling($messageHolder);
            }
        }
    }
}