<?php

namespace Pckg\Htmlbuilder;

use Pckg\Htmlbuilder\Element\Field;
use Pckg\Concept\ChainOfResponsibility;
use Pckg\Htmlbuilder\Handler\Method\Basic;
use Pckg\Htmlbuilder\Handler\Method\Query;
use Pckg\Htmlbuilder\Snippet\Attributes;
use Pckg\Htmlbuilder\Snippet\Builder;
use Pckg\Htmlbuilder\Snippet\Children;
use Pckg\Htmlbuilder\Snippet\Parenthesis;
use Pckg\Htmlbuilder\Snippet\Services;

/**
 * Class Element
 *
 * @package Pckg\Htmlbuilder
 * @method findChild(string $name)
 * @method findFirstByName(string $name)
 * @method closest(string $name)
 */
class Element
{
    use Attributes;
    use Services;
    use Builder;
    use Children;
    use Parenthesis;

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

    protected $childrenAliases = [];

    protected $tag = 'div';

    /**
     *
     */
    public function __construct()
    {
        $this->initFactories();

        $this->rebuildClass();

        foreach ($this->handlerFactory->create([Basic::class, Query::class,]) as $handler) {
            $this->addHandler($handler);
        }

        // $this->initBuilder();
    }

    public function __get($name)
    {
        if ($name == 'value') {
            return $this->getValue();
        }

        $first = $this->findChild('name=' . $name);

        if (!$first) {
            $first = $this->findChild('class=' . $name);
        }

        if (!$first) {
            $first = $this->findFirstByName($name);
        }

        if (!$first) {
            $first = $this->findChild('.' . $name);
        }

        return $first;
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->childrenAliases);
    }

    /*
    Autoload decorators and validators
    */
    /**
     * @return self
     */
    public function __call($method, $args)
    {
        $overloadMethod = 'overload' . ucfirst($method);

        $handlers = [];

        /**
         * Get all decorators, validators, ...
         */
        foreach ($this->getServices() as $service) {
            $methods = $service->getMethods();
            if (in_array($method, $methods)) {
                $handlers[] = $service;
            }
        }

        /**
         * Newly added? Works for validators?
         */
        if (!$handlers) {
            return $method == 'isValid'
                ? true // all ok
                : ($method == 'getErrorMessages' ? [] : $this);
            throw new \Exception('No handlers defined for ' . $method);
        }

        $context = $this->createContext();
        $context->setArgs($args);

        $element = $this;
        $result = chain(
            $handlers,
            $overloadMethod,
            ['context' => $context],
            function () use ($method, $element) {
                return $method === 'isValid'
                    ? true // all ok
                    : ($method === 'getErrorMessages' ? [] : $element);
            }
        );

        if (is_object($result) && $result === $handlers[0]) {
            return $this;
        }

        return $result;
    }

    public function addChildAlias($alias, $child)
    {
        $this->childrenAliases[$alias] = $child;

        return $this;
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
            'Decorator' => 'Decorators',
            'Validator' => 'Validators',
            'Handler'   => 'Handlers',
        ];

        foreach ($arr as $adder => $getter) {
            foreach ($parent->{'get' . $getter}() as $service) {
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
     * @return bool
     */
    public function matchesRegex($regex)
    {
        if ($regex == '*') {
            return true;
        } else if (substr($regex, 0, 1) == '.') {
            return $this->hasClass(substr($regex, 1));
        } else if (strpos($regex, 'name=') === 0) {
            return $this->getAttribute('name') == substr($regex, strlen('name='));
        } else {
            return $this->getTag() == $regex;
        }

        return false;
    }
}
