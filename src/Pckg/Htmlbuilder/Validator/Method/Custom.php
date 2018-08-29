<?php namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Validator\AbstractValidator;
use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class Custom extends AbstractValidator implements ValidatorInterface
{

    protected $call;

    public function __construct(callable $call)
    {
        $this->call = $call;
    }

    public function validate($value)
    {
        $call = $this->call;

        return $call($value);
    }

}