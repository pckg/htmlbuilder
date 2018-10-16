<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Form;

/**
 * Class AngularJS
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class VueJS extends AbstractDecorator
{

    /**
     * @var
     */
    protected $record;

    /**
     * @var string
     */
    protected $jsModel = 'form';

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = [
            'decorate',
            'jsModel',
        ];
    }

    public function overloadJsModel(callable $next, AbstractObject $context)
    {
        $this->jsModel = $context->getArg(0);
        $element = $context->getElement();
        foreach ($element->getChildren() as $child) {
            if (!($child instanceof Element)) {
                continue;
            }
            $child->jsModel($context->getArg(0));
        }

        return $next();
    }

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

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        if ($element instanceof Form) {
            $element->a('@submit.prevent', 'submitForm');
            $element->emptyAttribute('novalidate');
        } elseif (false && $element instanceof Element\Select) {
            $this->decorateSelect($element);
        } else {
            $this->decorateModel($element);
        }

        return $next();
    }

    private function decorateVModel($element)
    {
        $name = $this->getJSName($element);
        $element->setAttribute('v-model', $this->jsModel . '.' . $name);
    }

    private function getJSName($element)
    {
        $name = $element->getName($element);

        return str_replace(['[', ']'], ['.', ''], $name);
    }

    private function decorateVValidate($element)
    {
        if ($element->hasAttribute('required')) {
            $element->a('v-validate', "'required'");
        } else {
            $element->a('v-validate');
        }
    }

    private function decorateVVAs($element)
    {
        $name = $this->getJSName($element);
        $label = $element->getLabel();
        if ($label) {
            $element->a('data-vv-as', lcfirst($label));
        }

        $element->a('data-vv-name', $name);
    }

    private function decorateKeyUp($element)
    {
        $type = $element->getType();
        if (in_array($type, ['text', 'number', 'date'])) {
            $element->a('@keyup.enter', 'submitForm');
        }
    }

    /**
     * @param $element
     */
    protected function decorateModel($element)
    {
        $name = $this->getJSName($element);

        if (!$name) {
            return;
        }

        $type = $element->getAttribute('type');
        if (in_array($type, ['file', 'button', 'submit', 'reset', ''])) {
            return;
        }

        $this->decorateValidator($element);

        $this->decorateKeyUp($element);
    }

    private function decorateValidator($element, callable $before = null)
    {
        $name = $this->getJSName($element);

        if ($element->hasClass('datetime') || $element->getTag() == 'select') {
            $element->addClass('vue-takeover');
        }

        $this->decorateVModel($element);
        $this->decorateVValidate($element);
        $this->decorateVVAs($element);

        if ($before) {
            $before($element);
        }

        $element->addSibling('<htmlbuilder-validator-error :shown="errors.has(\'' . $name . '\')" :message="errors.first(\'' . $name . '\')"></htmlbuilder-validator-error>');
    }

    public function decorateSelect($element)
    {
        $this->decorateValidator($element, function($element){

            $options = collect($element->getChildren())->keyBy(function($option) {
                return $option->getAttribute('value');
            })->map(function($option) {
                return implode($option->getChildren());
            })->all();
            $vModel = $element->getAttribute('v-model');

            $element->addSibling('<pckg-select :initial-multiple="' . ($element->getAttribute('multiple') ? 'true' : 'false') . '"
            :initial-options="' . htmlspecialchars(json_encode($options)) . '" v-model="' . $vModel . '" :with-empty="false"></pckg-select>');

        });
    }

}