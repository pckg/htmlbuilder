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
        $name = $element->getName();
        if (!$name) {
            return;
        }

        $realName = str_replace(['[', ']'], ['.', ''], $name);
        $value = post($realName, request()->isPatch() ? AbstractDatasource::EMPTY : null);

        if ($value === AbstractDatasource::EMPTY) {
            if (request()->isPatch()) {
                return;
            }
            $value = null;
        } else if (!$value) {
            $value = $element->getDefaultValue();
        }

        if ($element instanceof Element\Input\File) {
            $value = files($realName, null);
        }

        /**
         * Filter value to expected (and valid!) values?
         */
        $element->setValue($value);

        if ($element instanceof Element\Input\Checkbox) {
            $element->setChecked($value);
        }
    }
}
