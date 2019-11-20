<?php namespace Pckg\Htmlbuilder\Builder;

use Pckg\Htmlbuilder\Element;

class Custom extends AbstractBuilder
{

    protected $builder;

    public function setBuilder(callable $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    public function build(Element $element = null)
    {
        $this->element = $element;

        return $this->builder($element);
    }

}