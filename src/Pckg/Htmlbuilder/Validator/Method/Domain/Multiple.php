<?php namespace Pckg\Htmlbuilder\Validator\Method\Domain;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Multiple extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter valid domains separated by space';

    protected $max = 10;

    public function validate($value)
    {
        $okIp = gethostbyname('startcomms.com');

        $this->msg .= ' pointing to ' . $okIp;

        $collection = collect(explode(' ', $value))->trim()->removeEmpty()->unique();

        return !$collection->has(function ($domain) {
                return !Single::isValidDomain($domain);
            }) && !$collection->has(function ($domain) use ($okIp) {
                return $okIp != gethostbyname($domain);
            }) && $collection->count() <= $this->max;
    }

}