<?php

namespace Pckg\Htmlbuilder\Element\Form;

use Pckg\Htmlbuilder\Decorator\Method\VueJS;
use Pckg\Htmlbuilder\Decorator\Method\Wrapper\Bootstrap as BootstrapDecoratorWrapper;
use Pckg\Htmlbuilder\Element\Form;

/**
 * Class Bootstrap
 *
 * @package Pckg\Htmlbuilder\Element\Form
 */
class Vue extends Bootstrap
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        foreach ($this->decoratorFactory->create([VueJS::class]) as $decorator) {
            $this->addDecorator($decorator);
        }
    }
}
