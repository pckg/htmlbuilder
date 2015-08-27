<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Concept\AbstractFactory;

/**
 * Class ValidatorFactory
 * @package Pckg\Htmlbuilder\Validator
 */
class ValidatorFactory extends AbstractFactory
{

    /**
     * @var array
     */
    protected $mapper = [
        'Csrf' => '\Pckg\Htmlbuilder\Validator\Method\Csrf',

        'Common' => '\Pckg\Htmlbuilder\Validator\Method\Common',
        'Common\Required' => '\Pckg\Htmlbuilder\Validator\Method\Common\Required',
        'Common\Unique' => '\Pckg\Htmlbuilder\Validator\Method\Common\Unique',
        'Common\Matches' => '\Pckg\Htmlbuilder\Validator\Method\Common\Matches',

        'Text' => '\Pckg\Htmlbuilder\Validator\Method\Text',
        'Text\Min' => '\Pckg\Htmlbuilder\Validator\Method\Text\Min',
        'Text\Max' => '\Pckg\Htmlbuilder\Validator\Method\Text\Max',

        'Number' => '\Pckg\Htmlbuilder\Validator\Method\Number',
        'Unique' => '\Pckg\Htmlbuilder\Validator\Method\Unique',
        'Datetime' => '\Pckg\Htmlbuilder\Validator\Method\Datetime',
        'Related' => '\Pckg\Htmlbuilder\Validator\Method\Related',
    ];

}