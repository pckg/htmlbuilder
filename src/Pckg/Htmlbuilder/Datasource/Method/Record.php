<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Database\Record as DatabaseRecord;
use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\ElementObject;

/**
 * Class Record
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Record extends AbstractDatasource
{

    /**
     * @var DatabaseRecord
     */
    protected $record;

    /**
     * @var bool
     */
    protected $recursive = true;

    public function populateFromRecord()
    {
        return $this;
    }

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['decorate', 'setRecord', 'getRecord', 'useRecordDatasource', 'populate'];
    }

    public function setRecord(DatabaseRecord $record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadSetRecord(callable $next, ElementObject $context)
    {
        $this->setRecord($context->getArg(0));

        return $next();
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
     * @return mixed
     */
    public function overloadGetRecord(callable $next, ElementObject $context)
    {
        if ($this->record) {
            return $this->getRecord();
        }

        return $next();
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadUseRecordDatasource(callable $next, ElementObject $context)
    {
        $this->enabled = true;

        return $next();
    }

    /**
     * @param ElementObject $context
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
     * @return mixed
     */
    public function decorateValue($element)
    {
        $name = $element->getAttribute('name');

        if (in_array($element->getTag(), [
                'input',
                'select',
                'textarea',
            ]) && $this->record && $this->record->__isset($name) && is_object($element) && $element->getAttribute('type') != 'password'
        ) {
            $value = $this->record->get($name);
            $element->setValue($value);
        }

        return $element;
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadPopulate(callable $next, ElementObject $context)
    {
        $this->populateRecord($context->getElement());

        return $next();
    }

    public function populateRecord($element)
    {
        if ($this->record && in_array($element->getTag(), ['input', 'select', 'textarea',]) && !in_array($element->getAttribute('type'), ['submit'])) {
            $value = $element->getValue($element->getName());
            $this->record->{$element->getName()} = $value;
        }
    }

}