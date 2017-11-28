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
            $value = post(str_replace(['[', ']'], ['.', ''], $name), null);
            $element->setValue($value);
        }
    }

}