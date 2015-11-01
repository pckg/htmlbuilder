<?php

namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\AbstractService;
use Pckg\Htmlbuilder\Datasource\DatasourceFactory;
use Pckg\Htmlbuilder\Datasource\DatasourceInterface;
use Pckg\Htmlbuilder\Decorator\DecoratorFactory;
use Pckg\Htmlbuilder\Decorator\DecoratorInterface;
use Pckg\Htmlbuilder\Element\ElementFactory;
use Pckg\Htmlbuilder\Handler\HandlerFactory;
use Pckg\Htmlbuilder\Handler\HandlerInterface;
use Pckg\Htmlbuilder\Validator\ValidatorFactory;
use Pckg\Htmlbuilder\Validator\ValidatorInterface;

/**
 * Class Services
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Services
{

    /*
      Bootstrap (decorator/theme) - properly encapsulates fields
      Record (data io) - sets val
      Post/Get/Files (data io) - links post with form
    */
    /**
     * @var
     */
    public $elementFactory;

    /*
     * Checked in __call(...)
     * Executed (decorate()) at toHTML()
     * */
    /**
     * @var array
     */
    protected $decorators = [];
    /**
     * @var bool
     */
    protected $decoratable = true;
    /**
     * @var
     */
    public $decoratorFactory;

    /*
     * Checked in __call(...)
     * */
    /**
     * @var array
     */
    protected $handlers = [];
    /**
     * @var bool
     */
    protected $handlable = true;
    /**
     * @var
     */
    public $handlerFactory;

    /*
     * Checked in __call(...)
     * */
    /**
     * @var array
     */
    protected $validators = [];
    /**
     * @var bool
     */
    protected $validatable = true;
    /**
     * @var
     */
    public $validatorFactory;

    /*
     * Checked in __call(...)
     * */
    /**
     * @var array
     */
    protected $datasources = [];
    /**
     * @var bool
     */
    protected $datasourcable = false;
    /**
     * @var
     */
    public $datasourceFactory;

    /**
     * @var array
     */
    protected $factories = [
        'Decorator' => [
            'factory' => DecoratorFactory::class,
        ],
        'Handler' => [
            'factory' => HandlerFactory::class,
        ],
        'Validator' => [
            'factory' => ValidatorFactory::class,
        ],
        'Datasource' => [
            'factory' => DatasourceFactory::class,
        ],
        'Element' => [
            'factory' => ElementFactory::class,
        ],
    ];

    /**
     * @param AbstractService $service
     * @param $stack
     */
    private function addUnique(AbstractService $service, &$stack)
    {
        if (!in_array($service, $stack)) {
            $stack[get_class($service)] = $service;

            //chain([$service], 'overloadInit', ['context' => $this->createContext()]);
            //$service->overloadInit($this->createContext());
        }
    }

    /**
     * @return array
     */
    public function getServices()
    {
        $arrServices = [];
        foreach ($this->factories as $serviceKey => $conf) {
            if (isset($this->{lcfirst($serviceKey) . 's'})) {
                foreach ($this->{lcfirst($serviceKey) . 's'} AS $service) {
                    $arrServices[] = $service;
                }
            }
        }

        return $arrServices;
    }

    /**
     * @param $event
     * @param $handler
     */
    public function on($event, $handler)
    {
        listen($event, $handler);
    }

    /**
     * @param $event
     * @param array $args
     */
    public function trigger($event, $args = [])
    {
        trigger($event, 'handle', $args);
    }

    /**
     *
     */
    protected function initFactories()
    {
        foreach ($this->factories as $type => $factory) {
            $this->{lcfirst($type) . 'Factory'} = context()->getOrCreate(lcfirst($type) . 'Factory', $factory['factory']);
        }
    }

    /**
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function addValidator(ValidatorInterface $validator)
    {
        $this->addUnique($validator, $this->validators);

        return $this;
    }

    /**
     * @param DecoratorInterface $decorator
     * @return $this
     */
    public function addDecorator(DecoratorInterface $decorator)
    {
        $this->addUnique($decorator, $this->decorators);

        return $this;
    }

    /**
     * @param HandlerInterface $handler
     * @return $this
     */
    public function addHandler(HandlerInterface $handler)
    {
        $this->addUnique($handler, $this->handlers);

        return $this;
    }

    /**
     * @param DatasourceInterface $datasource
     * @return $this
     */
    public function addDatasource(DatasourceInterface $datasource)
    {
        $this->addUnique($datasource, $this->datasources);

        return $this;
    }

    /**
     * @return array
     */
    public function getDecorators()
    {
        return $this->decorators;
    }

    /**
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @return array
     */
    public function getDatasources()
    {
        return $this->datasources;
    }

    /**
     * @return bool
     */
    public function hasDecorators()
    {
        return !empty($this->decorators);
    }

    /**
     * @return bool
     */
    public function hasValidators()
    {
        return !empty($this->validators);
    }

    /**
     * @return bool
     */
    public function hasHandlers()
    {
        return !empty($this->handlers);
    }

    /**
     * @return bool
     */
    public function hasDatasources()
    {
        return !empty($this->datasources);
    }

    /**
     * @param bool $decoratable
     * @return $this
     */
    public function setDecoratable($decoratable = true)
    {
        $this->decoratable = $decoratable;

        return $this;
    }

    /**
     * @param bool $validatable
     * @return $this
     */
    public function setValidatable($validatable = true)
    {
        $this->validatable = $validatable;

        return $this;
    }

    /**
     * @param bool $handlable
     * @return $this
     */
    public function setHandlable($handlable = true)
    {
        $this->handlable = $handlable;

        return $this;
    }

    /**
     * @param bool $datasourceable
     * @return $this
     */
    public function setDatasourceable($datasourceable = true)
    {
        $this->datasourcable = $datasourceable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDecoratable()
    {
        return $this->decoratable;
    }

    /**
     * @return bool
     */
    public function isValidatable()
    {
        return $this->validatable && count($this->validators) > 0;
    }

    /**
     * @return bool
     */
    public function isHandlable()
    {
        return $this->handlable;
    }

    /**
     * @return bool
     */
    public function isDatasourceable()
    {
        return $this->datasourcable;
    }

    /**
     * @param DecoratorFactory $decoratorFactory
     * @return $this
     */
    public function setDecoratorFactory(DecoratorFactory $decoratorFactory)
    {
        $this->decoratorFactory = $decoratorFactory;

        return $this;
    }

    /**
     * @param ValidatorFactory $validatorFactory
     * @return $this
     */
    public function setValidatorFactory(ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;

        return $this;
    }

    /**
     * @param HandlerFactory $handlerFactory
     * @return $this
     */
    public function setHandlerFactory(HandlerFactory $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;

        return $this;
    }

    /**
     * @param DatasourceFactory $datasourceFactory
     * @return $this
     */
    public function setDatasourceFactory(DatasourceFactory $datasourceFactory)
    {
        $this->datasourceFactory = $datasourceFactory;

        return $this;
    }

    /**
     * @param ElementFactory $elementFactory
     * @return $this
     */
    public function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;

        return $this;
    }

}