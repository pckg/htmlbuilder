<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Database\Record as DatabaseRecord;
use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\ElementObject;

/**
 * Class Record
 *
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Record extends AbstractDatasource
{

    /**
     * @var DatabaseRecord
     */
    protected $record;

    public function populateToDatasource()
    {
        $elements = $this->getElements();
        foreach ($elements as $element) {
            $this->populateRecord($element);
        }

        return $this;
    }

    protected function populateRecord(Element $element)
    {
        $name = $element->getName();
        if ($name && $this->record->hasKey($name)) {
            if ($element->getAttribute('type') != 'file') {
                $this->record->{$name} = $element->getValue();
            }
        }
    }

    public function populateToElement()
    {
        $elements = $this->getElements();
        foreach ($elements as $element) {
            $this->populateElement($element);
        }

        return $this;
    }

    protected function populateElement(Element $element)
    {
        $name = $element->getName();

        if ($name && $this->record->keyExists($name)) {
            if ($element->getAttribute('type') == 'checkbox') {
                $element->setValue(1);
                if ($this->record->{$name}) {
                    $element->setAttribute('checked', 'checked');
                }

            } else {
                $element->setValue($this->record->{$name});

            }
        }
    }

    /**
     * @param DatabaseRecord $record
     *
     * @return $this
     */
    public function setRecord(DatabaseRecord $record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * return null|DatabaseRecord
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param ElementObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, ElementObject $context)
    {
        $element = $context->getElement();

        $this->decorateValue($element);

        return $next();
    }

    /**
     * @param $element
     *
     * @return mixed
     */
    public function decorateValue($element)
    {
        $name = $element->getAttribute('name');

        if (in_array(
                $element->getTag(),
                [
                    'input',
                    'select',
                    'textarea',
                ]
            ) && $this->record && $this->record->__isset($name) && is_object($element) && $element->getAttribute(
                'type'
            ) != 'password'
        ) {
            $value = $this->record->get($name);
            $element->setValue($value);
        }

        return $element;
    }

}