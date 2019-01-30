<?php namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Validator\AbstractValidator;

class Color extends AbstractValidator
{

    protected $msg = 'Color should be in hex form (#b4d455)';

    public function validate($value)
    {
        return preg_match('/#([a-f0-9]{3}){1,2}\b/i', $value);
    }

}