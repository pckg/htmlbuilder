<?php

namespace Pckg\Htmlbuilder\Handler;

/**
 * Interface HandlerInterface
 *
 * @package Pckg\Htmlbuilder\Handler
 */
interface HandlerInterface
{
    /**
     * @return mixed
     */
    public function isRecursive();

    /**
     * @return mixed
     */
    public function canHandle($method);
}
