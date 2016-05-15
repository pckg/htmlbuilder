<?php

namespace Pckg\Htmlbuilder\Validator;

use Exception;
use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element;

/**
 * Class AbstractGroupValidator
 * @package Pckg\Htmlbuilder\Validator
 */
abstract class AbstractGroupValidator extends AbstractValidator implements ValidatorInterface
{

    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var array
     */
    protected $msgs = [];

    /**
     *
     */
    public function __clone()
    {
        foreach ($this->validators as &$validator) {
            $validator = clone $validator;
        }
    }

    /**
     *
     */
    public function initOverloadMethods()
    {
        parent::initOverloadMethods();

        foreach ($this->validators AS $validator) {
            $this->mergeOverloadMethods($validator->getMethods());
        }
    }

    /*
    Autoload subvalidators
    */
    /**
     * @param $method
     * @param $args
     * @return $this|mixed|null|object
     * @throws NotFound
     */
    public function __call($method, $args)
    {
        if (isset($args[0]) && $args[0] instanceof AbstractObject) {
            $arg = $args[0];
        } else {
            $arg = new AbstractObject();
            $arg->setArgs($args);
        }

        $arrChains = [];

        foreach ($this->validators AS $validator) {
            if ($validator->canHandle($method)) {
                $arrChains[] = $validator;
            }
        }

        if (!$arrChains) {
            throw new Exception('Method ' . $method . " doesn't exist in " . get_class($this) . " (AbstractGroupValidator::__call)");
        }

        $result = chain($arrChains, $method, ['context' => $arg]);

        if ($result === true) {
            return $this;
        }

        return $result;
    }

    /**
     * @param AbstractObject $context
     * @return bool
     */
    public function overloadIsValid(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();
        $value = $element->getValue();
        // @DEBUG var_dump("value", $value);
        $valid = $this->validate($value);

        // @DEBUG var_dump(($valid ? ' valid ' : ' INVALID ') . " in " . get_class($this));

        if ($this->next) {
            // @DEBUG var_dump("next is " . get_class($this->next));
        }

        // @DEBUG var_dump("overloadIsValid #valid", $valid);

        return $valid
            ? $next()
            : $valid;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        $this->msgs = [];
        foreach ($this->validators AS $validator) {
            if ($validator->isEnabled() && !$validator->validate($value)) {
                $this->msgs[] = $validator->getMsg();
            }
        }

        if ($this->msgs) {
            return false;
        }

        return parent::validate($value);
    }

    /**
     * @param $method
     * @return bool
     */
    public function canHandle($method)
    {
        foreach ($this->validators AS $validator) {
            if ($validator->canHandle($method)) {
                return true;
            }
        }

        return parent::canHandle($method);
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        $msgs = [];
        foreach ($this->validators AS $validator) {
            if (($msg = $validator->getMsg())) {
                $msgs[] = $msg;
            }
        }

        return implode(', ', $msgs);
    }

    /**
     * @param Element $element
     * @return string
     */
    public function getAngularJSValidator(Element $element)
    {
        $calls = [];

        foreach ($this->validators AS $validator) {
            if (($call = $validator->getAngularJSValidator($element))) {
                $calls[] = $call;
            }
        }

        return $calls
            ? implode(' && ', $calls)
            : '';
    }

}