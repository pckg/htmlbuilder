<?php

namespace Pckg\Htmlbuilder\Handler\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element\Fieldset;
use Pckg\Htmlbuilder\Handler\AbstractHandler;

/**
 * Class Basic
 * @package Pckg\Htmlbuilder\Handler\Method
 */
class Basic extends AbstractHandler
{

    /**
     * @param $method
     * @param $args
     * @return bool|mixed|object
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 11) == 'overloadAdd') {
            $key = substr($method, 11);

            $child = $this->elementFactory->create($key);

            if (isset($args[0])) {
                if ($args[0]->getArg(0)) {
                    if ($child instanceof Fieldset) {
                        $child->addClass($args[0]->getArg(0));

                    } else {
                        $child->setName($args[0]->getArg(0));

                    }
                }
                $args[0]->getElement()->addChild($child);
            } else {
                /*var_dump($args);
                die("54");
                if (isset($args[1][0])) {
                    $child->setName($args[1][0]);
                }

                $args[0]->addChild($child);*/
            }

            return $child;
        }

        return false;
    }

    /**
     *
     */
    public function initOverloadMethods()
    {
        parent::initOverloadMethods();

        $this->mergeOverloadMethods(['addMapped']);

        /*$arrMapper = array_keys($this->mapper);
        foreach ($arrMapper AS &$mapper) {
            $mapper = 'add' . ucfirst($mapper);
        }

        $this->mergeOverloadMethods($arrMapper);*/

        $arrMapper = $this->elementFactory->getMapperKeys();
        foreach ($arrMapper AS &$mapper) {
            $mapper = 'add' . ucfirst($mapper);
        }

        $this->mergeOverloadMethods($arrMapper);
    }

    /**
     * @param $method
     * @return bool
     */
    public function canHandle($method)
    {
        if (substr($method, 0, 11) == 'overloadAdd') {
            $key = substr($method, 11);

            if (isset($this->mapper[$key])) {
                return true;

            } else if ($this->elementFactory->canMap($key)) {
                return true;

            }
        }

        return parent::canHandle($method);
    }

    /**
     * @param AbstractObject $context
     * @return mixed|object
     */
    public function overloadAddMapped(callable $next, AbstractObject $context)
    {
        $child = $this->elementFactory->create(ucfirst($context->getArg(0)));

        if (!($child instanceof Fieldset)) {
            $child->setName($context->getArg(1));
        }

        $context->getElement()->addChild($child);

        return $child;
    }

}