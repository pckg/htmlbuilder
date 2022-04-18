<?php

namespace Pckg\Htmlbuilder\Decorator\Method\Bootstrap\Strategy;

use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\ElementObject;

class Form extends AbstractDecorator
{
    public function overloadDecorate(callable $next, ElementObject $context)
    {
        return $next();
    }
}
