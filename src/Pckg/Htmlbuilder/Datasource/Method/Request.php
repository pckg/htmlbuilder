<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Form;

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
        if ($name && isset($_POST[$name])) {
            $element->setValue($_POST[$name]);
        }
    }

}