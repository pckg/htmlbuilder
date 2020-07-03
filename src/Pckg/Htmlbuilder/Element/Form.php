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

        foreach ($this->handlerFactory->create([Step::class]) as $handler) {
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
        if (($child instanceof Submit || $child instanceof Button) && (!end($this->fieldsets)->hasClass('submit'))) {
            $this->addFieldset()->addClass('submit');
        }

        if (($child instanceof Field || $child instanceof Group) && $this->fieldsets) {
            /**
             * Add element to last fieldset.
             */
            $parent = end($this->fieldsets)->addChild($child);

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

        foreach ($this->fieldsets as $fieldset) {
            foreach ($fieldset->getFields() as $field) {
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
        foreach ($this->getFieldsets() as $fieldset) {
            foreach ($fieldset->getFields() as $field) {
                if ($field instanceof Group) {
                    foreach ($field->getChildren() as $subfield) {
                        $this->processDataField($subfield, $data);
                    }
                } else {
                    $this->processDataField($field, $data);
                }
            }
        }

        return $data;
    }

    /**
     * Return initial options for select.
     */
    public function getInitialOptions()
    {
        $data = [];
        foreach ($this->getFieldsets() as $fieldset) {
            foreach ($fieldset->getFields() as $field) {
                if ($field instanceof Group) {
                    foreach ($field->getChildren() as $subfield) {
                        if (!($subfield instanceof Select)) {
                            continue;
                        }
                        $this->processDataFieldOptions($subfield, $data);
                    }
                } else {
                    if (!($field instanceof Select)) {
                        continue;
                    }
                    $this->processDataFieldOptions($field, $data);
                }
            }
        }

        return $data;
    }

    private function processDataField($field, &$data)
    {
        if (!is_object($field)) {
            return;
        }

        $name = $field->getName();

        if (!$name) {
            return;
        }

        $type = $field->getAttribute('type');
        if (in_array($type, ['submit', 'button', 'reset'])) {
            return;
        }

        $startFirst = strpos($name, '['); // foo[bar]
        $startSecond = strpos($name, ']['); // foo[bar][baz]

        if ($startFirst) {
            $name2 = substr($name, 0, $startFirst);
            $name3 = substr($name, strlen($name2) + 1, $startSecond ? $startSecond - $startFirst - 1 : -1);

            if ($startSecond) {
                $name4 = substr($name, strlen($name2) + strlen($name3) + 3, -1);

                $data[$name2][$name3][$name4] = $type == 'checkbox'
                    ? $field->getAttribute('checked') == 'checked'
                    : $field->getValue();

                return;
            }

            $data[$name2][$name3] = $type == 'checkbox'
                ? $field->getAttribute('checked') == 'checked'
                : $field->getValue();
        } else {
            $data[$name] = $type == 'checkbox'
                ? $field->getAttribute('checked') == 'checked'
                : $field->getValue();
        }
    }

    private function processDataFieldOptions(Select $element, &$data)
    {
        $name = $element->getName();

        if (!$name) {
            return;
        }

        $options = $element->getAttribute('data-options');

        if ($options) {
            $options = json_decode($options, true);
        } else {
            /**
             * Check for children?
             */
            $options = [];
            foreach ($element->getChildren() as $option) {
                if (!is_object($option) || !($option instanceof Element\Select\Option)) {
                    continue;
                }

                $key = $option->getAttribute('value', '');
                $value = implode($option->getChildren());
                $options[$key] = $value;
            }
        }

        $startFirst = strpos($name, '['); // foo[bar]
        $startSecond = strpos($name, ']['); // foo[bar][baz]

        if ($startFirst) {
            $name2 = substr($name, 0, $startFirst);
            $name3 = substr($name, strlen($name2) + 1, $startSecond ? $startSecond - $startFirst - 1 : -1);

            if ($startSecond) {
                $name4 = substr($name, strlen($name2) + strlen($name3) + 3, -1);

                $data[$name2][$name3][$name4] = $options;

                return;
            }

            $data[$name2][$name3] = $options;
        } else {
            $data[$name] = $options;
        }
    }

    public function getCollectionData()
    {
        return new Collection($this->getData());
    }

    public function getRawData($keys = [])
    {
        if (!$keys) {
            return post()->all();
        }
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = post($key, null);
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
    function isValid(&$errors = [], &$descriptions = [])
    {
        foreach ($this->getFieldsets() as $fieldset) {
            foreach ($fieldset->getFields() as $field) {
                if ($field instanceof Element && $field->isValidatable() && $messages = $field->getErrorMessages()) {
                    $errors[] = $field->getName();
                    $descriptions[$field->getName()] = $messages;
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

    /**
     * @param array $fields
     * @return $this
     */
    public function fromArray(array $fields = [])
    {
        $auto = [
            'id',
            'hidden',
            'email',
            'text',
            'textarea',
            'editor',
            'integer',
            'decimal',
            'point',
        ];

        foreach ($fields as $field => $config) {
            $this->addText($field);
        }

        return $this;
    }

}