<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element;

/**
 * Class Request
 *
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class ArrayElement extends AbstractDatasource
{
    /**
     * @var
     */
    protected $request;

    public function populateToElement(array $data = [])
    {
        $elements = $this->getElements();

        foreach ($elements as $element) {
            $this->populateElement($element, $data);
        }

        return $this;
    }

    protected function populateElement(Element $element, array $data = [])
    {
        if ($name = $element->getName()) {
            $realName = str_replace(['[', ']'], ['.', ''], $name);
            $value = $data[$realName] ?? null;
            $element->setValue($value);
            if ($element instanceof Element\Input\Checkbox) {
                $element->setChecked($value);
            }
        }
    }
}
