<?php

namespace Pckg\Htmlbuilder\Element;

    /*
     * Factory for creating basic elements without validation, datasources or decorators
     * */

/**
 * Class ElementFactory
 *
 * @package Pckg\Htmlbuilder\Element
 */
class FormFactory extends ElementFactory
{

    /**
     * @var array
     */
    protected $mapper = [
        'Order'          => '\Test\Form\Order',
        'Order\Payee'    => '\Test\Form\Order\Payee',
        'Order\Shipping' => '\Test\Form\Order\Shipping',
        'Order\Payment'  => '\Test\Form\Order\Payment',
        'Vipster'        => '\Test\Form\Vipster',
        'Login'          => '\Weblab\User\Form\Login',
        'Register'       => '\Weblab\User\Form\Register',
    ];

    /**
     * @var array
     */
    protected $services = [
        'Pckg\Htmlbuilder\Element\Form' => [
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
        'Login'                         => [
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
    ];
}
