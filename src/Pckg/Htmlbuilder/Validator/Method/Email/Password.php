<?php namespace Pckg\Htmlbuilder\Validator\Method\Email;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Password extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Password should be minimum 8 characters long';

    public function validate($value)
    {
        if (strlen($value) < 8) {
            return false;
        }

        return true;
    }

}