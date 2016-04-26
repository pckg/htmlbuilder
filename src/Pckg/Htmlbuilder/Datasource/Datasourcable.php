<?php namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Database\Record as DatabaseRecord;
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

    /**
     * Populate element from request.
     *
     * @return $this
     */
    public function populateFromRequest()
    {
        (new Request())->setElement($this)
            ->populateToElement();

        return $this;
    }

    public function populateToRecord(DatabaseRecord $record)
    {
        (new Record())->setElement($this)
            ->setRecord($record)
            ->populateToDatasource();

        return $this;
    }

    public function populateToRecordAndSave(DatabaseRecord $record)
    {
        $this->populateToRecord($record);

        $record->save();

        return $this;
    }

    public function populateFromSession()
    {
        (new Session())->setElement($this)
            ->populateToElement();

        return $this;
    }

    public function populateToSession()
    {
        (new Session())->setElement($this)
            ->populateToDatasource();

        return $this;
    }

    public function populateFromRecord(DatabaseRecord $record)
    {
        (new Record())->setElement($this)
            ->setRecord($record)
            ->populateToElement();

        return $this;
    }

    public function populateFromRequestToRecord(DatabaseRecord $record)
    {
        $this->populateFromRequest();
        $this->populateFromElementToRecord($record);

        return $this;
    }

    public function populateFromSessionAndRecord(DatabaseRecord $record)
    {
        $this->populateFromSession();
        $this->populateFromRecord($record);

        return $this;
    }

}