<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Concept\AbstractFactory;
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

/**
 * Class ElementFactory
 *
 * @package Pckg\Htmlbuilder\Element
 */
class GnpElementFactory extends ElementFactory
{



    /**
     * @var array
     */
    protected $services = [
        'Pckg\Htmlbuilder\Element\Form'           => [
            'decorator'  => [
                'Record',
                //'Bootstrap',
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
                //'Bootstrap',
                //'Wrapper\Bootstrap',
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
                //'Bootstrap',
            ],
        ],
        'InputGroup'                              => [
            'decorator' => [
                //'Bootstrap',
            ],
        ],
        'CheckboxGroup'                           => [
            'decorator' => [
                //'Bootstrap',
            ],
        ],
        'InlineGroup'                             => [
            'decorator' => [
                //'Bootstrap',
            ],
        ],
        'Select'                                  => [
            'decorator' => [
                //'Bootstrap',
            ],
            'validator' => [
                'Common',
            ],
        ],
    ];
}
