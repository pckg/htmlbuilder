<?php namespace Pckg\Htmlbuilder\Builder;

use Pckg\Htmlbuilder\Element;

abstract class AbstractBuilder
{

    /**
     * @var Element
     */
    protected $element;

    public function __construct(Element $element)
    {
        $this->element = $element;
    }

}