<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;
use Pckg\Htmlbuilder\Validator\AbstractValidator;
use Pckg\Concept\AbstractObject;

class Profile extends Bootstrap
{

    public function init()
    {
        // name and surname are required texts
        $this->addText('name')->setLabel('Name:')->required();
        $this->addText('surname')->setLabel('Surname:')->required();

        //
        $this->addText('house_number')->setLabel('House number:')->required();
        $this->addText('apartment_number')->setLabel('Apartment number:');
        $this->addText('street')->setLabel('Street:')->required();
        $this->addText('street2')->setLabel('Street:');

        $this->addSelect('country')->setLabel('Country')->required()->useDatasource(entity('Countries')->all());

        // password field contains basic password validator (strength)
        // we need to add another one to match user's password
        $this->addPassword('current_password')->setLabel('Current password:')->required();
        $this->addPassword('new_password')->setLabel('New password:');
        $this->addPassword('repeat_password')->setLabel('Repeat new password:')/*->matches('new_password')*/
        ;

        $this->addSave();

        return $this;
    }

}

// this is v
class UserPasswordValidator extends AbstractValidator
{

    public function overloadIsValid(AbstractObject $context)
    {
        // we have form, element ...
        $password = $context->getElement()->getValue(); // since this is executed on post we get value from post

        if (!$password) {
            return true;
        }
    }

}