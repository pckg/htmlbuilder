<?php

namespace Pckg\Htmlbuilder\Decorator;

use Pckg\Concept\AbstractFactory;
use Pckg\Htmlbuilder\Decorator\Method\AngularJS;
use Pckg\Htmlbuilder\Decorator\Method\AngularJSValidator;
use Pckg\Htmlbuilder\Decorator\Method\Foundation;
use Pckg\Htmlbuilder\Decorator\Method\Post;
use Pckg\Htmlbuilder\Decorator\Method\Record;
use Pckg\Htmlbuilder\Decorator\Method\Step;
use Pckg\Htmlbuilder\Decorator\Method\Step\Horizontal;
use Pckg\Htmlbuilder\Decorator\Method\Step\Tabbed;
use Pckg\Htmlbuilder\Decorator\Method\Wrapper;
use Pckg\Htmlbuilder\Decorator\Method\Wrapper\Bootstrap;
use Pckg\Htmlbuilder\Decorator\Method\Wrapper\Foundation as FoundationWrapper;

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
        'AngularJS' => AngularJS::class,
        'AngularJSValidator' => AngularJSValidator::class,
        'Bootstrap' => Foundation::class,
        'Csrf' => '\Pckg\Htmlbuilder\Decorator\Method\Csrf',
        'Post' => Post::class,
        'Record' => Record::class,

        'Step' => Step::class,
        'Step\Tabbed' => Tabbed::class,
        'Step\Horizontal' => Horizontal::class,

        'Wrapper' => Wrapper::class,
        'Wrapper\Bootstrap' => Bootstrap::class,
        'Wrapper\Foundation' => FoundationWrapper::class,
    ];

}