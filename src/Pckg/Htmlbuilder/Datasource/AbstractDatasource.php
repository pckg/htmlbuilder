<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Htmlbuilder\Element;

/**
 * Class AbstractDatasource
 *
 * @package Pckg\Htmlbuilder\Datasource
 */
abstract class AbstractDatasource implements DatasourceInterface
{

    /**
     * @var Element
     */
    protected $element;

    /**
     * @param Element $element
     *
     * @return $this
     */
    public function setElement(Element $element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Populates data from datasource to element.
     *
     * @return $this
     */
    public function populateToElement()
    {
        return $this;
    }

    /**
     * Populates data from element to datasource.
     *
     * @return $this
     */
    public function populateToDatasource()
    {
        return $this;
    }

    public function getElements(Element $element = null)
    {
        $elements = [];
        if (!$element) {
            $element = $this->element;
            $elements[] = $element;
        }

        foreach ($element->getChildren() as $child) {
            if (is_subclass_of($child, Element::class)) {
                $elements[] = $child;
                $elements = array_merge($elements, $this->getElements($child));
            }
        }

        return $elements;
    }

}