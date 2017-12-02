<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
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
        ];
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
        } else {
            $this->decorateModel($element);
        }

        return $next();
    }

    /**
     * @param $element
     */
    protected function decorateModel($element)
    {
        $name = $element->getName();

        if (!$name) {
            return;
        }

        $type = $element->getAttribute('type');
        if (in_array($type, ['file', 'button', 'submit', 'reset'])) {
            return;
        }

        $name = str_replace(['[', ']'], ['.', ''], $name);

        $element->setAttribute('v-model', 'form.' . $name);

        if ($element->hasClass('datetime')) {
            $element->addClass('vue-takeover');
        }
    }
}