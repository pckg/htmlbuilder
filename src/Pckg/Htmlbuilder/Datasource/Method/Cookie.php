<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;

/*
 * Provides functionality for two way binding between form and cookie
 * */

/**
 * Class Cookie
 *
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Cookie extends AbstractDatasource
{

    /**
     * @var
     */
    protected $session;

    /**
     * @param $method
     *
     * @return bool
     */
    public function canHandle($method)
    {
        return isset($_COOKIE) && parent::canHandle($method);
    }
}
