<?php

namespace Pckg\Htmlbuilder;

use Pckg\Concept\AbstractChainOfReponsibility;
use Pckg\Concept\AbstractObject;

/**
 * Class AbstractService
 * @package Pckg\Htmlbuilder
 */
abstract class AbstractService extends AbstractChainOfReponsibility
{

    /**
     * @var bool
     */
    protected $recursive = false;

    /**
     * @var array
     */
    protected $methods = [];

    /**
     *
     */
    public function __construct()
    {
        $this->initOverloadMethods();
    }

    /**
     * @return bool
     */
    public function isRecursive()
    {
        return $this->recursive;
    }

    public function overloadInit(callable $next)
    {
        return $next();
    }

}