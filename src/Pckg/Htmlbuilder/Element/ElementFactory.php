<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Concept\AbstractFactory;
use Pckg\Htmlbuilder\Decorator\Method\Wrapper\Bootstrap;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Button\Cancel;
use Pckg\Htmlbuilder\Element\Button\Submit;
use Pckg\Htmlbuilder\Element\Group\CheckboxGroup;
use Pckg\Htmlbuilder\Element\Group\InlineGroup;
use Pckg\Htmlbuilder\Element\Group\InputGroup;
use Pckg\Htmlbuilder\Element\Group\RadioGroup;
use Pckg\Htmlbuilder\Element\Input\Checkbox;
use Pckg\Htmlbuilder\Element\Input\Date;
use Pckg\Htmlbuilder\Element\Input\Datetime;
use Pckg\Htmlbuilder\Element\Input\Email;
use Pckg\Htmlbuilder\Element\Input\File;
use Pckg\Htmlbuilder\Element\Input\File\Picture;
use Pckg\Htmlbuilder\Element\Input\Hidden;
use Pckg\Htmlbuilder\Element\Input\Number;
use Pckg\Htmlbuilder\Element\Input\Password;
use Pckg\Htmlbuilder\Element\Input\Radio;
use Pckg\Htmlbuilder\Element\Input\Text;
use Pckg\Htmlbuilder\Element\Input\Time;
use Pckg\Htmlbuilder\Element\Select\Option;
use Pckg\Htmlbuilder\Validator\Method\Common;
use Pckg\Htmlbuilder\Validator\Method\Number as NumberValidator;
use Pckg\Htmlbuilder\Validator\Method\Text as TextValidator;

/**
 * Class ElementFactory
 *
 * @package Pckg\Htmlbuilder\Element
 */
class ElementFactory extends AbstractFactory
{
    /**
     * @var array
     */
    protected array $mapper = [
        'Element'       => Element::class,
        'Fieldset'      => Fieldset::class,
        'Div'           => Div::class,
        'Label'         => Label::class,
        'Ul'            => Ul::class,
        'Field'         => Field::class,
        'Id'            => Hidden::class,
        'Hidden'        => Hidden::class,
        'Select'        => Select::class,
        'Option'        => Option::class,
        'Foreign'       => Select::class,
        'Password'      => Password::class,
        'Email'         => Email::class,
        'Text'          => Text::class,
        'Slug'          => Text::class,
        'Textarea'      => Textarea::class,
        'Editor'        => Textarea::class,
        'Html'          => Textarea::class,
        'Varchar'       => Input::class,
        'File'          => File::class,
        'Picture'       => Picture::class,
        'Int'           => Number::class,
        'Number'        => Number::class,
        'Date'          => Date::class,
        'Time'          => Time::class,
        'Datetime'      => Datetime::class,
        'Checkbox'      => Checkbox::class,
        'Bool'          => Checkbox::class,
        'Submit'        => Submit::class,
        'Save'          => Submit::class,
        'Cancel'        => Cancel::class,
        'Button'        => Button::class,
        'CheckboxGroup' => CheckboxGroup::class,
        'InputGroup'    => InputGroup::class,
        'RadioGroup'    => RadioGroup::class,
        'InlineGroup'   => InlineGroup::class,
        'Radio'         => Radio::class,
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
                'Wrapper\Bootstrap',
            ],
            'validator' => [
                'Common',
            ],
        ],
        'Pckg\Htmlbuilder\Element'                => [
            'validator' => [
                'Common',
            ],
        ],
        'Pckg\Htmlbuilder\Element\Input\Password' => [
            'validator' => [
                'Common',
            ],
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
                'Bootstrap',
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
        Number::class                             => [
            'decorator' => [Bootstrap::class],
            'validator' => [Common::class, NumberValidator::class],
        ],
        Number\Decimal::class                     => [
            'decorator' => [Bootstrap::class],
            'validator' => [Common::class, NumberValidator::class],
        ],
        Text::class                               => [
            'validator' => [Common::class, TextValidator::class],
        ],
    ];

    /**
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
