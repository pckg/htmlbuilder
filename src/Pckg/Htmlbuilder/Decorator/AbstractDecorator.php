<?php

namespace Pckg\Htmlbuilder\Decorator;

use Pckg\Htmlbuilder\AbstractService;
use Pckg\Htmlbuilder\Element\ElementFactory;

/**
 * Class AbstractDecorator
 * @package Pckg\Htmlbuilder\Decorator
 */
abstract class AbstractDecorator extends AbstractService implements DecoratorInterface
{

    /**
     * @var ElementFactory
     */
    protected $elementFactory;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->elementFactory = new ElementFactory();
    }

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = [];
    }

    /**
     * @param ElementFactory $elementFactory
     * @return $this
     */
    public function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;

        return $this;
    }

}