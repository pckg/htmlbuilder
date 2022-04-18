<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Concept\AbstractObject;

/**
 * Interface ValidatorInterface
 *
 * @package Pckg\Htmlbuilder\Validator
 */
interface ValidatorInterface
{
    /**
     * @return mixed
     */
    public function isRecursive();

    /**
     * @return mixed
     */
    public function canHandle($method);

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadIsValid(callable $next, AbstractObject $context);

    /**
     * @return mixed
     */
    public function addError($error);

    /**
     * @return mixed
     */
    public function getErrors();
}
