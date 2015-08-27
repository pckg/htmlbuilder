<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Concept\AbstractObject;

/*
 * AngularJS is element decorator which adds few AngularJS directives to elements.
 * You can simply automatically bind every element and form to Angular scope.
 *
 * */

/**
 * Class AngularJS
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class AngularJS extends AbstractDecorator
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
     * @return mixed
     */
    public function setRecord(AbstractObject $context)
    {
        $this->record = $context->getArg(0);

        return $this->next->setRecord($context);
    }

    /*
     * Decorator logic
     * */
    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadDecorate(AbstractObject $context)
    {
        $element = $context->getElement();

        $this->decorateModel($element);

        return $this->next->overloadDecorate($context);
    }

    /*
     * Takes an element and chooses specific decorating method
     * */
    /**
     * @param $element
     */
    protected function decorateModel($element)
    {
        if ($element->getName() && in_array($element->getTag(), ['input', 'select', 'textarea']) && !in_array($element->getAttribute('type'), ['submit', 'button'])) {
            $this->setName($element);

        } else if ($element->getName() && in_array($element->getTag(), ['form'])) {
            $this->setForm($element);

        }
    }

    /*
     * Binds element to angular object
     * */
    /**
     * @param $element
     */
    protected function setName($element)
    {
        $elementName = $element->getName();
        if (strpos($elementName, '[')) {
            // we're dealing with object
            $element->setAttribute('ng-model', str_replace(['[', ']', '..'], ['.'], $elementName));
        } else {
            // simple =)
            $form = $element->closest('form');
            $formName = $form
                ? $form->getAttribute('name')
                : null;

            if (!$formName) {
                $formName = 'unknown';
            }

            $element->setAttribute('ng-model', $formName . '.' . $elementName);
        }

        $element->setAttribute('ng-initial');

        // is this needed?
        $element->setAttribute('ng-name', $element->getAttribute('ng-model'));
    }

    /*
     * Decorates form with controller and submit handler
     * Also unsets action to prevent default action
     * */
    /**
     * @param $element
     */
    protected function setForm($element)
    {
        //$element->setAttribute('ng-controller', 'FormController');
        $element->setAttribute('ng-submit', $element->getAttribute('id') . '.$valid && handleSubmit(' . $element->getName() . ', ' . 'obj' . ucfirst(str_replace(['[', ']', '..'], ['.'], substr($element->getName(), 4))) . ')');
        $element->unsetAttribute('action');
        $element->setAttribute('novalidate');
    }
}