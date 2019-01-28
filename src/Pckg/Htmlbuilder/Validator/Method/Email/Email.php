<?php namespace Pckg\Htmlbuilder\Validator\Method\Email;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Email extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter valid email';

    public function validate($value)
    {
        return isValidEmail($value, true);
    }

}