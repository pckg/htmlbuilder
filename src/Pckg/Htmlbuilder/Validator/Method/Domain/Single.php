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
            && preg_match('/^(?:[-A-Za-z0-9\.]+)+[A-Za-z]{2,6}$/i', $domain);
    }

}