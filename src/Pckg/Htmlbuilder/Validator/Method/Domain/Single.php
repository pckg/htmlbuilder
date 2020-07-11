<?php namespace Pckg\Htmlbuilder\Validator\Method\Domain;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Single extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter valid domain';

    public function validate($value)
    {
        if (!static::isValidDomain($value)) {
            return false;
        }

        $okIp = gethostbyname('startcomms.com');

        $this->msg .= ' pointing to ' . $okIp;

        $ip = gethostbyname($value);

        return $ip == $okIp;
    }

    /**
     * https://stackoverflow.com/questions/3026957/how-to-validate-a-domain-name-using-regex-php
     *
     * @param $domain
     * @return bool
     */
    public static function isValidDomain($domain)
    {
        return strlen($domain) <= 253 && preg_match('^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$', $domain);
    }

}