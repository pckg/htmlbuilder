<?php namespace Pckg\Htmlbuilder\Validator\Method\Domain;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Single extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter valid domain';

    public function validate($value)
    {
        return static::isValidDomain($value);
    }

    /**
     * https://stackoverflow.com/questions/3026957/how-to-validate-a-domain-name-using-regex-php
     *
     * @param $domain
     * @return bool
     */
    public static function isValidDomain($domain)
    {
        return strlen($domain) <= 253
            && preg_match('/^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/ig', $domain);
    }

}