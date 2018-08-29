<?php namespace Pckg\Htmlbuilder\Validator\Method\Email;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class MultipleEmails extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter emails separated by space and commas';

    public function validate($value)
    {
        $value = str_replace(',', ' ', $value);
        $value = str_replace('  ', '  ', $value);

        return !collect(explode(' ', $value))->removeEmpty()->has(function($email) {
            return !isValidEmail($email);
        });
    }

}