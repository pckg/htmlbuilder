<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Htmlbuilder\Element;

/**
 * Class AbstractDatasource
 * @package Pckg\Htmlbuilder\Datasource
 */
abstract class AbstractDatasource implements DatasourceInterface
{

    /**
     * @var Element
     */
    protected $element;

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

}