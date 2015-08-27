<?php

namespace Pckg\Htmlbuilder\Decorator;

use Pckg\Concept\AbstractFactory;

/**
 * Class DecoratorFactory
 * @package Pckg\Htmlbuilder\Decorator
 */
class DecoratorFactory extends AbstractFactory
{

    /**
     * @var array
     */
    protected $mapper = [
        'AngularJS' => '\Pckg\Htmlbuilder\Decorator\Method\AngularJS',
        'AngularJSValidator' => '\Pckg\Htmlbuilder\Decorator\Method\AngularJSValidator',
        'Bootstrap' => '\Pckg\Htmlbuilder\Decorator\Method\Foundation',
        'Csrf' => '\Pckg\Htmlbuilder\Decorator\Method\Csrf',
        'Post' => '\Pckg\Htmlbuilder\Decorator\Method\Post',
        'Record' => '\Pckg\Htmlbuilder\Decorator\Method\Record',

        'Step' => '\Pckg\Htmlbuilder\Decorator\Method\Step',
        'Step\Tabbed' => '\Pckg\Htmlbuilder\Decorator\Method\Step\Tabbed',
        'Step\Horizontal' => '\Pckg\Htmlbuilder\Decorator\Method\Step\Horizontal',

        'Wrapper' => '\Pckg\Htmlbuilder\Decorator\Method\Wrapper',
        'Wrapper\Bootstrap' => '\Pckg\Htmlbuilder\Decorator\Method\Wrapper\Bootstrap',
        'Wrapper\Foundation' => '\Pckg\Htmlbuilder\Decorator\Method\Wrapper\Foundation',
    ];

}