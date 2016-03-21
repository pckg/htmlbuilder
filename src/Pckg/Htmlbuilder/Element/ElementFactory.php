<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Concept\AbstractFactory;

/*
 * Factory for creating basic elements without validation, datasources or decorators
 * */

/**
 * Class ElementFactory
 * @package Pckg\Htmlbuilder\Element
 */
class ElementFactory extends AbstractFactory
{

    /**
     * @var array
     */
    protected $mapper = [
        'Element'       => '\Pckg\Htmlbuilder\Element',
        'Fieldset'      => '\Pckg\Htmlbuilder\Element\Fieldset',
        'Div'           => '\Pckg\Htmlbuilder\Element\Div',
        'Label'         => '\Pckg\Htmlbuilder\Element\Label',
        'Ul'            => '\Pckg\Htmlbuilder\Element\Ul',
        'Id'            => '\Pckg\Htmlbuilder\Element\Input\Hidden',
        'Hidden'        => '\Pckg\Htmlbuilder\Element\Input\Hidden',
        'Select'        => '\Pckg\Htmlbuilder\Element\Select',
        'Option'        => '\Pckg\Htmlbuilder\Element\Select\Option',
        'Foreign'       => '\Pckg\Htmlbuilder\Element\Select',
        'Password'      => '\Pckg\Htmlbuilder\Element\Input\Password',
        'Email'         => '\Pckg\Htmlbuilder\Element\Input\Email',
        'Text'          => '\Pckg\Htmlbuilder\Element\Input\Text',
        'Slug'          => '\Pckg\Htmlbuilder\Element\Input\Text',
        'Textarea'      => '\Pckg\Htmlbuilder\Element\Textarea',
        'Editor'        => '\Pckg\Htmlbuilder\Element\Textarea',
        'Html'          => '\Pckg\Htmlbuilder\Element\Textarea',
        'Varchar'       => '\Pckg\Htmlbuilder\Element\Input',
        'File'          => '\Pckg\Htmlbuilder\Element\Input\File',
        'Picture'       => '\Pckg\Htmlbuilder\Element\Input\File\Picture',
        'Int'           => '\Pckg\Htmlbuilder\Element\Input\Number',
        'Number'        => '\Pckg\Htmlbuilder\Element\Input\Number',
        'Date'          => '\Pckg\Htmlbuilder\Element\Input\Date',
        'Time'          => '\Pckg\Htmlbuilder\Element\Input\Time',
        'Datetime'      => '\Pckg\Htmlbuilder\Element\Input\Datetime',
        'Checkbox'      => '\Pckg\Htmlbuilder\Element\Input\Checkbox',
        'Bool'          => '\Pckg\Htmlbuilder\Element\Input\Checkbox',
        'Submit'        => '\Pckg\Htmlbuilder\Element\Button\Submit',
        'Save'          => '\Pckg\Htmlbuilder\Element\Button\Submit',
        'Cancel'        => '\Pckg\Htmlbuilder\Element\Button\Cancel',
        'Button'        => '\Pckg\Htmlbuilder\Element\Button',
        'CheckboxGroup' => '\Pckg\Htmlbuilder\Element\Group\CheckboxGroup',
        'InputGroup'    => '\Pckg\Htmlbuilder\Element\Group\InputGroup',
        'RadioGroup'    => '\Pckg\Htmlbuilder\Element\Group\RadioGroup',
        'InlineGroup'   => '\Pckg\Htmlbuilder\Element\Group\InlineGroup',
        'Radio'         => '\Pckg\Htmlbuilder\Element\Input\Radio',
    ];

    /**
     * @var array
     */
    protected $services = [
        'Pckg\Htmlbuilder\Element\Form'           => [
            'decorator'  => [
                'Record',
                'Bootstrap',
                'Post',
            ],
            'validator'  => [
                'Common',
            ],
            'datasource' => [
                'Session',
                'Request',
                'Record',
                'Entity',
            ],
        ],
        'Pckg\Htmlbuilder\Element\Fieldset'       => [
            'decorator' => [
                'Bootstrap',
                'Wrapper',
            ],
            'validator' => [
                'Common',
            ]
        ],
        'Pckg\Htmlbuilder\Element'                => [
            'validator' => [
                'Common',
            ]
        ],
        'Pckg\Htmlbuilder\Element\Input\Password' => [
            'validator' => [
                'Common',
            ]
        ],
        'RadioGroup'                              => [
            'decorator' => [
                'Bootstrap',
            ],
        ],
        'InputGroup'                              => [
            'decorator' => [
                'Bootstrap',
            ],
        ],
        'CheckboxGroup'                           => [
            'decorator' => [
                'Bootstrap',
            ],
        ],
        'InlineGroup'                             => [
            'decorator' => [
                'Bootstrap'
            ],
        ],
        'Select'                                  => [
            'decorator' => [
                'Bootstrap',
            ],
            'validator' => [
                'Common',
            ],
        ],
    ];

    /**
     * @param $expression
     * @return Element
     */
    public function createFromExpression($expression)
    {
        $idStart = strpos($expression, '#');
        $classStart = strpos($expression, '.');
        $attrStart = strpos($expression, '[');
        $tagStart = $idStart === 0 || $classStart === 0 || $attrStart === 0
            ? false
            : 0;

        $tagEnd = $idStart ?: $classStart ?: $attrStart ?: strlen($expression);
        $idEnd = $classStart ?: $attrStart ?: strlen($expression);
        $classEnd = $attrStart ?: strlen($expression);
        $attrEnd = strlen($expression);

        $tag = '';
        $id = '';
        $class = '';
        $attributes = '';

        if ($tagStart !== false && $tagStart < $tagEnd) {
            $tag = substr($expression, $tagStart, $tagEnd - $tagStart);
        }

        if ($idStart !== false && $idStart < $idEnd) {
            $id = substr($expression, $idStart + 1, $idEnd - $idStart - 1);
        }

        if ($classStart !== false && $classStart < $classEnd) {
            $class = substr($expression, $classStart + 1, $classEnd - $classStart);
        }

        if ($attrStart !== false && $attrStart < $attrEnd) {
            $attributes = substr($expression, $attrStart, $attrEnd - $attrStart);
        }

        if ($tag && $this->canMap(ucfirst($tag))) {
            $element = $this->create(ucfirst($tag));

        } else {
            $element = $this->create('Element');

        }

        if ($tag) {
            $element->setTag($tag);
        }

        if ($id) {
            $element->setId($id);
        }

        if ($class) {
            $element->addClass($class);
        }

        return $element;
    }

}