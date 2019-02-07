<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\AbstractService;

/**
 * Class AbstractValidator
 *
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
    protected $msg = 'Enter valid value';

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    protected $errors = [];

    /**
     * @param bool $enabled
     *
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

        $this->mergeOverloadMethods(['isValid', 'getErrorMessages']);
    }

    /**
     * @param AbstractObject $context
     *
     * @return bool
     */
    public function overloadIsValid(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();
        $value = $element->getValue();
        $valid = $this->validate($value);

        return $valid
            ? $next()
            : $valid;
    }

    public function overloadGetErrorMessages(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();
        $value = $element->getValue();
        $valid = $this->validate($value);

        if (!$valid) {
            $msg = $this->getMsg();

            return $msg;
        }

        return $next();
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
     * @return $this
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function validate($value)
    {
        return true;
    }

}