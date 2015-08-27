<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class ForgotPassword extends Bootstrap
{

    public function initFields()
    {
        $this->addEmail('email')// also adds email validator
        ->setLabel('Email:')
            ->required(); // adds required validator

        $this->addSave();

        return $this;
    }

}