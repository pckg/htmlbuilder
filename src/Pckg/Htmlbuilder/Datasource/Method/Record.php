<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\ElementObject;

/*
 * Provides functionality for two way binding between form and record
 * */

/**
 * Class Record
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Record extends AbstractDatasource
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
        $this->methods = ['decorate', 'setRecord', 'getRecord', 'useRecordDatasource'];
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadSetRecord(callable $next, ElementObject $context)
    {
        $this->record = $context->getArg(0);

        return $next();
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadGetRecord(callable $next, ElementObject $context)
    {
        if ($this->record) {
            return $this->record;
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

        // $this->overloadUseRecordDatasource($context);

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
                'textarea'
            ]) && $this->record && $this->record->__isset($name) && is_object($element) && $element->getAttribute('type') != 'password'
        ) {
            $value = $this->record->get($name);
            $element->setValue($value);
        }

        return $element;
    }

}