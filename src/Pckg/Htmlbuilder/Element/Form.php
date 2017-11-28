<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Collection;
use Pckg\Htmlbuilder\Datasource\Datasourcable;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Button\Submit;
use Pckg\Htmlbuilder\Handler\Method\Step;
use Pckg\Htmlbuilder\Snippet\Buildable;

/**
 * Class Form
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Form extends Element
{

    use Buildable, Datasourcable;

    /**
     * @var string
     */
    protected $tag = 'form';

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

        $this->setAttribute('action', router()->getUri());
        $this->setID('form' . array_reverse(explode('\\', get_class($this)))[0]);
        $this->setName('form' . array_reverse(explode('\\', get_class($this)))[0]);
        $this->setMethod('post');
        $this->setMultipart();

        foreach ($this->handlerFactory->create([Step::class]) AS $handler) {
            $this->addHandler($handler);
        }

        $this->formFactory = new FormFactory();

        $this->addFieldset();
    }

    /**
     * @param $child
     *
     * @return $this
     */
    public function addChild($child)
    {
        if ($child instanceof Fieldset) {
            $this->fieldsets[] = $child;
        } else if (!$this->fieldsets) {
            $this->addFieldset();
        }

        if ($child instanceof Form && !$this->isStepped()) {
            $child->setTag('div')->setClass('wrappedForm');
        }

        // add another fieldset for buttons
        if (($child instanceof Submit || $child instanceof Button) && (!$this->fieldsets || !end(
                    $this->fieldsets
                )->hasClass('submit'))
        ) {
            $this->addChild($this->elementFactory->create('Fieldset')->addClass('submit'));
        }

        if (($child instanceof Field || $child instanceof Group) && $this->fieldsets) {
            /**
             * Add element to last fieldset.
             */
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
     * @return Fieldset
     */
    public function getFieldset()
    {
        if (!$this->fieldsets) {
            $this->addFieldset();
        }

        return end($this->fieldsets);
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
        $data = [];
        foreach ($this->getFieldsets() AS $fieldset) {
            foreach ($fieldset->getFields() AS $field) {
                if ($field instanceof Field) {
                    $this->processDataField($field, $data);
                } elseif ($field instanceof Group) {
                    foreach ($field->getChildren() AS $subfield) {
                        $this->processDataField($subfield, $data);
                    }
                }
            }
        }

        return $data;
    }

    private function processDataField($field, &$data)
    {
        $type = $field->getAttribute('type');
        if (in_array($type, ['submit', 'button', 'reset'])) {
            return;
        }
        $name = $field->getName();

        if ($type == 'checkbox') {
            $data[$name] = $field->getAttribute('checked') == 'checked';
        } else {
            $data[$name] = $field->getValue();
        }
    }

    public function getCollectionData()
    {
        return new Collection($this->getData());
    }

    public function getRawData($keys = [])
    {
        if (!$keys) {
            return $_POST;
        }
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $_POST[$key] ?? null;
        }

        return $values;
    }

    /**
     * @param $action
     *
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
     *
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
     *
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
                if ($field instanceof Element && $field->isValidatable() && !$field->isValid() &&
                    $errs = $field->getErrors()
                ) {
                    $errors[] = $errs;
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