<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Concept\AbstractFactory;
use Pckg\Database\Record;
use Pckg\Htmlbuilder\Datasource\Method\Collection;
use Pckg\Htmlbuilder\Datasource\Method\Entity;
use Pckg\Htmlbuilder\Datasource\Method\Mailchimp;
use Pckg\Htmlbuilder\Datasource\Method\Request;
use Pckg\Htmlbuilder\Datasource\Method\Session;

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
        'Record'     => Record::class,
        'Request'    => Request::class,
        'Session'    => Session::class,
        'Entity'     => Entity::class,
        'Collection' => Collection::class,
        'Mailchimp'  => Mailchimp::class,
    ];

}