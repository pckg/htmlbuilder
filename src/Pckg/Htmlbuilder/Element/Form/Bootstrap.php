<?php

namespace Pckg\Htmlbuilder\Element\Form;

use Pckg\Htmlbuilder\Decorator\Method\Bootstrap as BootstrapDecorator;
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

        foreach ($this->decoratorFactory->create([BootstrapDecorator::class]) as $decorator) {
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