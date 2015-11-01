<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Htmlbuilder\ElementObject;

/**
 * Interface DatasourceInterface
 * @package Pckg\Htmlbuilder\Datasource
 */
interface DatasourceInterface
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
     * @param $method
     * @return mixed
     */
    public function canHandle($method);

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function populate(callable $next, ElementObject $context);

}