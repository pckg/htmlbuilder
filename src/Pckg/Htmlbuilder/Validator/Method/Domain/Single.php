<?php namespace Pckg\Htmlbuilder\Validator\Method\Domain;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Single extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter valid domain';

    public function validate($value)
    {
        $okIp = gethostbyname('startcomms.com');

        $this->msg .= ' pointing to ' . $okIp;

        $ip = gethostbyname($value);

        return $ip == $okIp;
    }

}