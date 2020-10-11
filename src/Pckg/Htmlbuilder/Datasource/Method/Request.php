<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element;

/**
 * Class Request
 *
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Request extends AbstractDatasource
{

    /**
     * @var
     */
    protected $request;

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
        if ($name = $element->getName()) {
            $realName = str_replace(['[', ']'], ['.', ''], $name);
            $value = post($realName, $element->getDefaultValue());
            if ($element instanceof Element\Input\File) {
                $value = files($realName, null);
            }
            $element->setValue($value);
            if ($element instanceof Element\Input\Checkbox) {
                $element->setChecked($value);
            }
        }
    }

}