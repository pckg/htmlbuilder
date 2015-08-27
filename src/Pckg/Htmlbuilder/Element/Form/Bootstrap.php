<?php

namespace Pckg\Htmlbuilder\Element\Form;

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

        $this->setMethod('post');

        $this->setHorizontal();

        $this->setMultipart();
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