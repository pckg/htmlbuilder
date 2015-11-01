<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class ForgotPassword extends Bootstrap
{

    public function init()
    {
        $this->addEmail('email')
            ->setLabel('Email:')
            ->required();

        $this->addSave();

        return $this;
    }

}