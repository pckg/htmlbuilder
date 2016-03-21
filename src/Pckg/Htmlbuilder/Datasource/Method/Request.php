<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\ElementObject;

/*
 * Provides functionality for two way binding between form and request data (post)
 * */

/**
 * Class Request
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Request extends AbstractDatasource
{

    /**
     * @var
     */
    protected $request;

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['useRequestDatasource'];
    }

    /*
     * This may be called on form, fieldset, field or some other element ...
     * */
    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadUseRequestDatasource(callable $next, ElementObject $context)
    {
        $this->enabled = true;

        $this->autofill($context, $context->getElement());

        return $next();
    }

    /*public function overloadDecorate(callable $next, AbstractObject $context) {
        if ($this->enabled) {
            $this->autofill($context);
        }

        return $next();
    }*/

    /**
     * @param ElementObject $context
     * @param Element       $element
     */
    private function autofill(ElementObject $context, Element $element)
    {
        $this->decorateValue($context, $element);

        foreach ($element->getChildren() AS $child) {
            if ($child instanceof Element) {
                $this->autofill($context, $child);
            }
        }
    }

    /**
     * @param $context
     * @param $element
     * @return mixed
     */
    public function decorateValue($context, $element)
    {
        $formName = lcfirst(substr($context->getElement()->getName(), 4));
        $name = $element->getAttribute('name');

        if ($formName && $name && in_array($element->getTag(),
                ['input', 'select', 'textarea']) && isset($_POST[$formName][$name])
        ) {
            $value = $_POST[$formName][$name];
            $element->setValue($value);
        }

        return $element;
    }

    /**
     * @param $method
     * @return bool
     */
    public function canHandle($method)
    {
        return isset($_POST) && parent::canHandle($method);
    }

    /**
     *
     */
    public function setRequest()
    {

    }

}