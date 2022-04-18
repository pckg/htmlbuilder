<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Validator\AbstractValidator;

class Custom extends AbstractValidator
{
    protected $recursive = false;

    protected $call;

    public function __construct(callable $call)
    {
        parent::__construct();

        $this->call = $call;
    }

    public function validate($value)
    {
        $call = $this->call;

        return $call($value, $this);
    }
}
