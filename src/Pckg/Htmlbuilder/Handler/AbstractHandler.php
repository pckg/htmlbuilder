<?php

namespace Pckg\Htmlbuilder\Handler;

use Pckg\Htmlbuilder\AbstractService;
use Pckg\Htmlbuilder\Element\ElementFactory;

/**
 * Class AbstractHandler
 *
 * @package Pckg\Htmlbuilder\Handler
 */
abstract class AbstractHandler extends AbstractService implements HandlerInterface
{

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     *
     */
    public function __construct()
    {
        $this->elementFactory = new ElementFactory();

        parent::__construct();
    }

    /**
     * @param ElementFactory $elementFactory
     *
     * @return $this
     */
    public function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;

        return $this;
    }
}
