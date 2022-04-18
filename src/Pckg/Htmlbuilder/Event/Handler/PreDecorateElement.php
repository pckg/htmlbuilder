<?php

namespace Pckg\Htmlbuilder\Event\Handler;

use Pckg\Concept\AbstractChainOfReponsibility;
use Pckg\Concept\AbstractObject;

/**
 * Class PreDecorateElement
 *
 * @package Pckg\Htmlbuilder\Event\Handler
 */
class PreDecorateElement extends AbstractChainOfReponsibility
{
    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function handle(AbstractObject $context)
    {
        if ($context->getElement()->hasDecorators() && !isset($context->getElement()->predecorated)) {
            $context->getElement()->predecorated = true;
            $context->getElement()->preDecorate();
        }

        return $this;
    }
}
