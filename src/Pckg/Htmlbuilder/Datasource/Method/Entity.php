<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element\Select;
use Pckg\Htmlbuilder\ElementObject;

/**
 * Class Entity
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Entity extends AbstractDatasource
{

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     * @var null
     */
    protected $entity = null;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['decorate', 'useEntityDatasource'];
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadUseEntityDatasource(ElementObject $context)
    {
        $this->enabled = true;

        $this->entity = $context->getArg(0);

        return $this->next->overloadUseEntityDatasource($context);
    }

    /**
     * @param ElementObject $context
     * @return mixed
     */
    public function overloadDecorate(ElementObject $context)
    {
        if ($this->enabled) {
            $element = $context->getElement();

            if ($element instanceof Select) {
                $this->decorateSelect($element);
            }
        }

        return $this->next->overloadDecorate($context);
    }

    /**
     * @param $element
     */
    protected function decorateSelect($element)
    {
        $arr = $this->entity->findListID();

        $element->addOptions($arr);
    }

}