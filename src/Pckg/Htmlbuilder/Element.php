<?php

namespace Pckg\Htmlbuilder;

use Pckg\Htmlbuilder\Handler\Method\Basic;
use Pckg\Htmlbuilder\Handler\Method\Query;
use Pckg\Htmlbuilder\Snippet\Attributes;
use Pckg\Htmlbuilder\Snippet\Builder;
use Pckg\Htmlbuilder\Snippet\Children;
use Pckg\Htmlbuilder\Snippet\Parenthesis;
use Pckg\Htmlbuilder\Snippet\Services;

/**
 * Class Element
 * @package Pckg\Htmlbuilder
 */
class Element
{

    use Attributes, Services, Builder, Children, Parenthesis;

    /**
     * @var null
     */
    protected $element = null;
    /**
     * @var bool
     */
    protected $selfClosing = false;

    /**
     * @var array
     */
    protected $siblings = [];

    /**
     *
     */
    public function __construct()
    {
        $this->initFactories();

        $this->rebuildClass();

        foreach ($this->handlerFactory->create([Basic::class, Query::class,]) AS $handler) {
            $this->addHandler($handler);
        }

        $this->initBuilder();
    }

    /*
    Autoload decorators and validators
    */
    /**
     * @param $method
     * @param $args
     *
     * @return self
     */
    public function __call($method, $args)
    {
        $overloadMethod = 'overload' . ucfirst($method);

        $handlers = [];

        foreach ($this->getServices() AS $service) {
            if (in_array($method, $service->getMethods())) {
                $handlers[] = $service;
            }
        }

        $context = $this->createContext();
        $context->setArgs($args);

        $result = chain($handlers, $overloadMethod, ['context' => $context], function () {
            return $this;
        });

        return $result;
    }

    /**
     * @return ElementObject
     */
    public function createContext()
    {
        $context = new ElementObject();
        $context->setElement($this);

        return $context;
    }

    /*
    Sets tag
    */
    /**
     * @param null $tag
     *
     * @return $this
     */
    public function setTag($tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /*
    Gets tag
    */
    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param $sibling
     *
     * @return $this
     */
    public function addSibling($sibling)
    {
        if ($sibling) {
            $this->siblings[] = $sibling;

            if ($sibling instanceof Element && $this->getParent()) {
                $sibling->transferFromElement($this->getParent());
            }
        }

        return $this;
    }

    /**
     * @param Element $parent
     */
    protected function transferFromElement(Element $parent)
    {
        if (!$parent->getParent()) {
            $this->pushParent($parent);
        }

        $arr = [
            'Decorator'  => 'Decorators',
            'Validator'  => 'Validators',
            'Handler'    => 'Handlers',
        ];

        foreach ($arr AS $adder => $getter) {
            foreach ($parent->{'get' . $getter}() AS $service) {
                if ($service->isRecursive()) {
                    if ($getter == 'Handler') {
                        $this->{'add' . $adder}($service);
                    } else {
                        $this->{'add' . $adder}(clone $service);
                    }
                }
            }
        }
    }

    /**
     * @param $regex
     *
     * @return bool
     */
    public function matchesRegex($regex)
    {
        if ($regex == '*') {
            return true;

        } else if (substr($regex, 0, 1) == '.') {
            return $this->hasClass(substr($regex, 1));

        } else {
            return $this->getTag() == $regex;

        }

        return false;
    }

}