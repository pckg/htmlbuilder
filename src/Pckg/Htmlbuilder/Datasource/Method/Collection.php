<?php

namespace Pckg\Htmlbuilder\Datasource\Method;

use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Element\Select;
use Pckg\Htmlbuilder\ElementObject;

/**
 * Class Collection
 *
 * @package Pckg\Htmlbuilder\Datasource\Method
 */
class Collection extends AbstractDatasource
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
        $this->methods = ['decorate', 'useCollectionDatasource'];
    }

    /**
     * @param ElementObject $context
     *
     * @return mixed
     */
    public function overloadUseCollectionDatasource(callable $next, ElementObject $context)
    {
        $this->enabled = true;

        $this->entity = $context->getArg(0);

        return $next();
    }

    /**
     * @param ElementObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, ElementObject $context)
    {
        if ($this->enabled) {
            $element = $context->getElement();

            if ($element instanceof Select) {
                $this->decorateSelect($element);
            }
        }

        return $next();
    }

    /**
     * @param $element
     */
    protected function decorateSelect($element)
    {
        // $arr = $this->entity->all()->getList();

        // $element->addOptions($arr);
    }
}
