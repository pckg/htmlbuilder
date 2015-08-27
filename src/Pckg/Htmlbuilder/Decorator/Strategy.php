<?php

namespace Pckg\Htmlbuilder\Decorator;

use Pckg\Htmlbuilder\Element;
use Pckg\Concept\AbstractObject;

trait Strategy
{

    // protected $strategy; // required in class

    public function overloadUseStrategy(AbstractObject $context)
    {
        $this->strategy = is_object($context->getArg(0))
            ? $context->getArg(0)
            : $context->getElement()->decoratorFactory->create($context->getArg(0));

        return $this->next->overloadUseStrategy($context);
    }

    protected function createStrategy(Element $element)
    {
        if (!is_object($this->strategy)) {
            $this->strategy = $element->decoratorFactory->create($this->strategy);
        }

        return $this;
    }

}