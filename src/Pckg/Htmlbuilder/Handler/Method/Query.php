<?php

namespace Pckg\Htmlbuilder\Handler\Method;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Field;
use Pckg\Htmlbuilder\Handler\AbstractHandler;
use Pckg\Concept\AbstractObject;

/**
 * Class Query
 * @package Pckg\Htmlbuilder\Handler\Method
 */
class Query extends AbstractHandler
{

    /**
     *
     */
    protected function initOverloadMethods()
    {
        parent::initOverloadMethods();

        $this->mergeOverloadMethods(['closest', 'farest', 'findFirstByName', 'findChild', 'findChildren', 'removeChildren', 'getIndex']);
    }

    /**
     * @param AbstractObject $context
     * @return bool
     */
    public function overloadClosest(AbstractObject $context)
    {
        $regex = $context->getArg(0);

        $element = $context->getElement();
        $parent = $element->getParent();

        if (!$parent) {
            return false;
        }

        if ($parent->matches($regex)) {
            return $parent;
        }

        return $parent->overloadClosest($regex);
    }

    /**
     * @param AbstractObject $context
     * @return $this
     */
    public function overloadFarest(AbstractObject $context)
    {
        $regex = $context->getArg(0);

        $element = $context->getElement();
        $parent = $element->getParent();

        if (!$parent && $this->matches($regex)) {
            return $this;

        } else if ($parent && ($farest = $parent->overloadFarest($regex))) {
            return $farest;

        }

        $context->setReturn(false);

        $this->next->overloadFarest();
    }

    /**
     * @param AbstractObject $context
     * @return null
     */
    public function overloadFindFirstByName(AbstractObject $context)
    {
        $name = $context->getArg(0);
        $element = $context->getElement();

        if ($element instanceof Field && $element->getAttribute('name') == $name) {
            return $element;
        }

        foreach ($element->getChildren() as $child) {
            $result = $child->findFirstByName($name);

            if ($result && $result != $element) {
                return $result;
            }
        }

        $context->setReturnMethod('null');

        return $this->next->overloadFindFirstByName($context);
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadFindChild(AbstractObject $context)
    {
        $regex = $context->getArg(0);

        foreach ($context->getElement()->getChildren() as $child) {
            if ($child instanceof Element && $child->matchesRegex($regex)) {
                return $child;
            }
        }

        $context->handleReturnNull();

        return $this->next->overloadFindChild($context);
    }

    /**
     * @param AbstractObject $context
     * @return array
     */
    public function overloadFindChildren(AbstractObject $context)
    {
        $regex = $context->getArg(0);

        $arrChildren = [];
        foreach ($context->getElement()->getChildren() as $child) {
            if ($child instanceof Element && $child->matchesRegex($regex)) {
                $arrChildren[] = $child;
            }
        }

        return $arrChildren;
    }

    /**
     * @param AbstractObject $context
     * @return array
     */
    public function overloadRemoveChildren(AbstractObject $context)
    {
        $regex = $context->getArg(0);
        $element = $context->getElement();

        $arrChildren = [];
        foreach ($element->getChildren() as $i => $child) {
            if ($child instanceof Element && $child->matchesRegex($regex)) {
                $arrChildren[] = $child;
                $element->unsetChild($i);
            }
        }

        return $arrChildren;
    }

    /**
     * @param AbstractObject $context
     * @return int|string
     */
    public function overloadGetIndex(AbstractObject $context)
    {
        $element = $context->getElement();

        if (!$element->getParent()) {
            $context->setReturn(null);

        } else {
            foreach ($element->getParent()->getChildren() AS $i => $child) {
                if ($child === $element) {
                    return $i;
                }
            }
        }

        return $this->next->overloadGetIndex($context);
    }

}