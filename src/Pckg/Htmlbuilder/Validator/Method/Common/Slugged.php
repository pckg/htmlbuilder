<?php

namespace Pckg\Htmlbuilder\Validator\Method\Common;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\AbstractValidator;

/**
 * Class Slugged
 *
 * @package Pckg\Htmlbuilder\Validator\Method\Common
 */
class Slugged extends AbstractValidator
{
    /**
     * @var string
     */
    protected $msg = 'Only alphanumeric and dash are available';

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['slugged'];
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSlugged(callable $next, AbstractObject $context)
    {
        $this->setEnabled();

        return $next();
    }

    /**
     * @return bool
     */
    public function validate($value)
    {
        return $value === trim(sluggify($value), ' -');
    }
}
