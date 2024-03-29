<?php

namespace Pckg\Htmlbuilder;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Validator\ValidatorInterface;

class ElementObject extends AbstractObject
{
    /**
     * @var null
     */
    protected $element = null;

    /**
     * @return null
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param Element $element
     *
     * @return $this
     */
    public function setElement(Element $element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * @param ValidatorInterface $validator
     *
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @return null
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }
}
