<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class Register extends Bootstrap
{

    public function init()
    {
        $this->addEmail('email')// also adds email validator
        ->setLabel('Email:')
            ->required() // adds required validator
            //->unique(); // adds unique validator
        ;

        $this->addPassword('password')// also adds password validator
        ->setLabel('Password:')
            ->required(); // adds required validator

        $this->addPassword('password2')// also adds password validator
        ->setLabel('Repeat password:')
            //->matches('password')
            ->required(); // adds required validator

        $this->addSave();

        return $this;
    }

}