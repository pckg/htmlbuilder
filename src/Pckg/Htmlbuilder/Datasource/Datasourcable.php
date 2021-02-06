<?php

namespace Pckg\Htmlbuilder\Datasource;

use Pckg\Database\Record as DatabaseRecord;
use Pckg\Htmlbuilder\Datasource\Method\ArrayElement;
use Pckg\Htmlbuilder\Datasource\Method\Record;
use Pckg\Htmlbuilder\Datasource\Method\Request;
use Pckg\Htmlbuilder\Datasource\Method\Session;

trait Datasourcable
{

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

    public function populateFromArray(array $data = [])
    {
        (new ArrayElement())->setElement($this)
                       ->populateToElement($data);
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
        $this->populateToRecord($record);
        return $this;
    }

    public function populateFromSessionAndRecord(DatabaseRecord $record)
    {
        $this->populateFromSession();
        $this->populateFromRecord($record);
        return $this;
    }
}
