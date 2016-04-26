<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;

/*
 * Provides functionality for two way binding between form and session
 * */

/**
 * Class Session
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Session extends AbstractDatasource
{

    /**
     * @var
     */
    protected $session;

    public function populateFromSession()
    {
        return $this;
    }

    /**
     * @param $method
     * @return bool
     */
    public function canHandle($method)
    {
        return isset($_SESSION) && parent::canHandle($method);
    }


}