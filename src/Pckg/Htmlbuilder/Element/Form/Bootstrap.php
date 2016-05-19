<?php

namespace Pckg\Htmlbuilder\Element\Form;

use Pckg\Htmlbuilder\Decorator\Method\Wrapper\Bootstrap as BootstrapDecoratorWrapper;
use Pckg\Htmlbuilder\Element\Form;

/**
 * Class Bootstrap
 * @package Pckg\Htmlbuilder\Element\Form
 */
class Bootstrap extends Form
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setHorizontal();

        foreach ($this->decoratorFactory->create([BootstrapDecoratorWrapper::class]) as $decorator) {
            $this->addDecorator($decorator);
        }
    }

    /**
     *
     */
    public function setInline()
    {
        $this->addClass("form-inline");
    }

    /**
     *
     */
    public function setHorizontal()
    {
        $this->addClass("form-horizontal");
    }
}