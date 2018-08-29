<?php namespace Pckg\Htmlbuilder\Validator\Method\Domain;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Multiple extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter valid domains separated by space';

    public function validate($value)
    {
        $okIp = gethostbyname('startcomms.com');

        $this->msg .= ' pointing to ' . $okIp;

        return !collect(explode(' ', $value))->trim()->removeEmpty()->unique()->has(function($domain) use ($okIp) {
            return $okIp != gethostbyname($domain);
        });
    }

}