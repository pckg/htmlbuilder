<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class Login extends Bootstrap
{

    public function init()
    {
        $this->addDiv()->setTag('legend')->addChild('Simple form with required email and password fields');

        $this->addEmail('email')->setLabel('Email:')->required();

        $this->addPassword('password')->setLabel('Password:')->required();

        $this->addSave();

        return $this;
    }

}