<?php

namespace Pckg\Htmlbuilder\Validator;

use Exception;
use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\Method\Text;

/**
 * Class AbstractGroupValidator
 *
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
            $methods = $validator->getMethods();
            $this->mergeOverloadMethods($methods);
        }
    }

    /*
    Autoload subvalidators
    */
    /**
     * @param $method
     * @param $args
     *
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
            throw new Exception(
                'Method ' . $method . " doesn't exist in " . get_class($this) . " (AbstractGroupValidator::__call)"
            );
        }

        $result = chain($arrChains, $method, ['context' => $arg], function() use ($method, $args) {
            return $method == 'isValid' ? true : (isset($args[1]) && is_only_callable($args[1]) ? $args[1]() : $this);
        });

        return $result;
    }

    /**
     * @param $value
     *
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
     *
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
        return implode(', ', $this->msgs);
    }

    /**
     * @param Element $element
     *
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