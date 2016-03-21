<?php

namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Concept\AbstractFactory;
use Pckg\Htmlbuilder\AbstractService;

/**
 * Class Service
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Service
{

    /**
     * @var string
     */
    protected $name = 'services';
    /**
     * @var array
     */
    protected $services = [];
    /**
     * @var bool
     */
    protected $serviceable = true;
    /**
     * @var
     */
    public $serviceFactory;

    /**
     * @param AbstractService $service
     * @param                 $stack
     */
    private function addUnique(AbstractService $service, &$stack)
    {
        if (!in_array($service, $stack)) {
            $stack[get_class($service)] = $service;
        }
    }

    /**
     * @param AbstractService $service
     * @return $this
     */
    public function addService(AbstractService $service)
    {
        $this->addUnique($service, $this->{$this->name});

        return $this;
    }


    /**
     * @return mixed
     */
    /*public function getServices()
    {
        return $this->{$this->name};
    }*/

    /**
     * @return bool
     */
    public function hasServices()
    {
        return !empty($this->{$this->name});
    }

    /**
     * @param bool $serviceable
     * @return $this
     */
    public function setServiceable($serviceable = true)
    {
        $this->serviceable = $serviceable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isServiceable()
    {
        return $this->serviceable;
    }

    /**
     * @param AbstractFactory $serviceFactory
     * @return $this
     */
    public function setServiceFactory(AbstractFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;

        return $this;
    }

}