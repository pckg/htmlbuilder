<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Htmlbuilder\AbstractService;
use Pckg\Concept\AbstractObject;

/**
 * Class AbstractValidator
 * @package Pckg\Htmlbuilder\Validator
 */
abstract class AbstractValidator extends AbstractService implements ValidatorInterface
{

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var string
     */
    protected $msg = '';

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled = true)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->validatorFactory = new ValidatorFactory();
    }

    /**
     *
     */
    protected function initOverloadMethods()
    {
        parent::initOverloadMethods();

        $this->mergeOverloadMethods(['isValid']);
    }

    /**
     * @param AbstractObject $context
     * @return bool
     */
    public function overloadIsValid(AbstractObject $context)
    {
        $element = $context->getElement();
        $value = null;
        $valid = $this->validate($value);

        return $valid
            ? $this->next->isValid($context)
            : $valid;
    }

    /**
     * @param $value
     */
    public function addError($value)
    {
        $this->errors[] = $value;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return true;
    }

}