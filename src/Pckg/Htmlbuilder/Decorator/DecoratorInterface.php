<?php

namespace Pckg\Htmlbuilder\Decorator;

/**
 * Interface DecoratorInterface
 *
 * @package Pckg\Htmlbuilder\Decorator
 */
interface DecoratorInterface
{
    /**
     *
     */
    public function __construct();

    /**
     * @return mixed
     */
    public function isRecursive();

    /**
     * @return mixed
     */
    public function canHandle($method);
}
