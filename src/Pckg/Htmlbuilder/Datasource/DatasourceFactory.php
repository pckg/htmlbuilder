<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Concept\AbstractFactory;

/**
 * Class DatasourceFactory
 * @package Pckg\Htmlbuilder\Datasource
 */
class DatasourceFactory extends AbstractFactory
{

    /**
     * @var array
     */
    protected $mapper = [
        'Record'     => '\Pckg\Htmlbuilder\Datasource\Method\Record',
        'Request'    => '\Pckg\Htmlbuilder\Datasource\Method\Request',
        'Session'    => '\Pckg\Htmlbuilder\Datasource\Method\Session',
        'Entity'     => '\Pckg\Htmlbuilder\Datasource\Method\Entity',
        'Collection' => '\Pckg\Htmlbuilder\Datasource\Method\Collection',
    ];

}