<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Database\Record as DatabaseRecord;
use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Datasource\Datasourcable;
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
        $realName = str_replace(['[', ']'], ['.', ''], $name);

        if (!$name) {
            return;
        }
        if (!$this->record->hasKey($name)) {
            return;
        }

        $value = $element->getValue();

        if (request()->isPatch() && (post($realName, AbstractDatasource::EMPTY) === AbstractDatasource::EMPTY)) {
            return;
        }

        if (in_array($element->getAttribute('type'), ['file', 'password'])) {
            // file and password fields are handled manually ... currently ... ;-)
        } elseif ($element->hasClass(['geo', 'point'])) {
            // geometric point
            $raw = $element->getValue();
            $value = $raw ? explode(';', $raw) : [0, 0];

            if (count($value) <= 1) {
                $value = [0, 0];
            } else if (count($value) > 2) {
                $value = array_slice($value, 0, 2);
            }

            $this->record->{$name} = $value ?? null;
        } else {
            $this->record->{$name} = $element->getValue();
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

        if (!$name) {
            return;
        }

        if (!$this->record->keyExists($name)) {
            return;
        }

        if ($element->getAttribute('type') == 'checkbox') {
            $element->setValue(1);
            if ($this->record->{$name}) {
                $element->setAttribute('checked', 'checked');
            }
        } elseif ($element->getAttribute('type') == 'password') {
            // do nothing
        } elseif ($element->hasClass(['geo', 'point'])) {
            $element->setValue($this->record->{$name . '_x'} . ';' . $this->record->{$name . '_y'});
        } else {
            $element->setValue($this->record->{$name});
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
     * @return mixed
     */
    public function decorateValue($element)
    {
        $name = $element->getAttribute('name');

        if (
            in_array(
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
