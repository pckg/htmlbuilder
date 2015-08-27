<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;

/**
 * Class Form
 * @package Pckg\Htmlbuilder\Element
 */
class Form extends Element
{

    /**
     * @var string
     */
    protected $tag = 'form';

    // each form should have fieldset
    /**
     * @var array
     */
    protected $fieldsets = [];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setID('form' . array_reverse(explode('\\', get_class($this)))[0]);
        $this->setName('form' . array_reverse(explode('\\', get_class($this)))[0]);

        $this->setMultipart();

        foreach ($this->handlerFactory->create(['Step']) AS $handler) {
            $this->addHandler($handler);
        }

        foreach ($this->datasourceFactory->create(['Record', 'Request', 'Session', 'Entity']) AS $datasource) {
            $this->addDatasource($datasource);
        }

        $this->formFactory = new FormFactory();
    }

    /**
     * @param $child
     * @return $this
     */
    public function addChild($child)
    {
        if ($child instanceof Fieldset) {
            $this->fieldsets[] = $child;

        }

        if ($child instanceof Form && !$this->isStepped()) {
            $child->setTag('div')->setClass('wrappedForm');

        }

        // add another fieldset for buttons
        if (($child instanceof Element\Button\Submit || $child instanceof Element\Button) && (!$this->fieldsets || !end($this->fieldsets)->hasClass('submit'))) {
            $this->addChild($this->elementFactory->create('Fieldset')->addClass('submit'));
        }

        if ($child instanceof Field && $this->fieldsets) {
            end($this->fieldsets)->addChild($child);

            if ($child instanceof Element) {
                $child->transferFromElement($this);
            }

            return $this;
        }

        return parent::addChild($child);
    }

    /**
     * @return array
     */
    public function getFieldsets()
    {
        return $this->fieldsets;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        $arrFields = [];

        foreach ($this->fieldsets AS $fieldset) {
            foreach ($fieldset->getFields() AS $field) {
                $arrFields[] = $field;
            }
        }

        return $arrFields;
    }

    /**
     *
     */
    public function getData()
    {
        foreach ($this->getFieldsets() AS $fieldset) {
            foreach ($fieldset->getFields() AS $field) {
                $name = $field->getName();
            }
        }
    }

    public function getRawData()
    {
        return $_POST;
    }

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->setAttribute("action", $action);

        return $this;
    }

    /**
     * @return null
     */
    public function getAction()
    {
        return $this->getAttribute("action");
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->setAttribute("method", $method);

        return $this;
    }

    /**
     * @return null
     */
    public function getMethod()
    {
        return $this->getAttribute("method");
    }

    /**
     * @param bool $multipart
     * @return $this
     */
    public function setMultipart($multipart = true)
    {
        if ($multipart) {
            $this->setAttribute("enctype", "multipart/form-data");
        } else {
            $this->unsetAttribute("enctype");
        }

        return $this;
    }

    /**
     * @return bool
     */
    function isValid()
    {
        $errors = [];
        foreach ($this->getFieldsets() AS $fieldset) {
            foreach ($fieldset->getFields() AS $field) {
                if ($field->isValidatable() && !$field->isValid()) {
                    $errors[] = $field->getErrors();
                }
            }
        }

        if ($errors) {
            return false;
        }

        return true;
    }

    public function initFields()
    {
        return $this;
    }
}