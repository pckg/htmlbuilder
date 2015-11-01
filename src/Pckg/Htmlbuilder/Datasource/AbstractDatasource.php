<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Htmlbuilder\AbstractService;
use Pckg\Htmlbuilder\ElementObject;

/**
 * Class AbstractDatasource
 * @package Pckg\Htmlbuilder\Datasource
 */
abstract class AbstractDatasource extends AbstractService implements DatasourceInterface
{

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     *
     */
    public function disableDatasources()
    {
        $this->enabled = false;
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function populate(callable $next, ElementObject $context)
    {
        return $next();
    }

}