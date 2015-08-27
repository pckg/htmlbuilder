<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\ElementFactory;
use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class Login extends Bootstrap
{

    public function __construct()
    {
        parent::__construct();

        $this->elementFactory = new ElementFactory();
    }

    public function init()
    {
        $div = $this->addDiv();
        $div->setTag('legend');
        $div->addChild('Simple form with required email and password fields');

        $this->addEmail('email')// also adds email validator
        ->setLabel('Email:')
            ->required(); // adds required validator

        $this->addPassword('password')// also adds password validator
        ->setLabel('Password:')
            ->required(); // adds required validator

        $this->addSave();

        return $this;
    }

}