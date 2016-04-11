<?php namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Htmlbuilder\Datasource\Method\Collection;
use Pckg\Htmlbuilder\Datasource\Method\Cookie;
use Pckg\Htmlbuilder\Datasource\Method\Entity;
use Pckg\Htmlbuilder\Datasource\Method\Record;
use Pckg\Htmlbuilder\Datasource\Method\Request;
use Pckg\Htmlbuilder\Datasource\Method\Session;

trait Datasourcable
{

    /**
     * @param $class
     * @return DatasourceInterface
     */
    private function addDatasourceByClass($class)
    {
        $datasource = $this->datasourceFactory->create($class);

        $this->addDatasource($datasource);

        return $datasource;
    }

    /**
     * @return Collection
     */
    public function useCollectionDatasource()
    {
        return $this->addDatasourceByClass(Collection::class);
    }

    /**
     * @return Collection
     */
    public function useCookieDatasource()
    {
        return $this->addDatasourceByClass(Cookie::class);
    }

    /**
     * @return Entity
     */
    public function useEntityDatasource()
    {
        return $this->addDatasourceByClass(Entity::class);
    }

    /**
     * @return Record
     */
    public function useRecordDatasource()
    {
        return $this->addDatasourceByClass(Record::class);
    }

    /**
     * @return Request
     */
    public function useRequestDatasource()
    {
        return $this->addDatasourceByClass(Request::class);
    }

    /**
     * @return Session
     */
    public function useSessionDatasource()
    {
        return $this->addDatasourceByClass(Session::class);
    }

}