<?php namespace Pckg\Htmlbuilder\Validator\Method\Email;

use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class MultipleEmails extends \Pckg\Htmlbuilder\Validator\AbstractValidator implements ValidatorInterface
{

    protected $recursive = false;

    protected $msg = 'Please enter max 5 emails separated by space';

    protected $max = 5;

    public function validate($value)
    {
        $collection = collect(explode(' ', $value))->removeEmpty();

        return !$collection->has(function($email) {
                return !isValidEmail($email);
            }) && $collection->count() <= $this->max;
    }

}