<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;

/**
 * Class Fieldset
 * @package Pckg\Htmlbuilder\Element
 */
class Fieldset extends Element
{

    /**
     * @var string
     */
    protected $tag = 'fieldset';

    // each fieldset should be added to form
    /**
     * @var null
     */
    protected $form = null;

    // each fieldset should have some fields
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @param $form
     * @return $this
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return null
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $child
     * @return $this
     */
    public function addChild($child)
    {
        if ($child instanceof Element) {
            $this->fields[] = $child;
        }

        return parent::addChild($child);
    }

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->addHandler($this->handlerFactory->create('Basic', 'Query', 'Step'));
    }

    /**
     * @return array
     */
    public function getFields()
    {
        $arrFields = [];

        foreach ($this->getChildren() AS $field) {
            $arrFields[] = $field;
        }

        return $arrFields;
    }

}