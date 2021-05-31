<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Concept\AbstractFactory;
use Pckg\Htmlbuilder\Validator\Method\Common;
use Pckg\Htmlbuilder\Validator\Method\Common\Matches;
use Pckg\Htmlbuilder\Validator\Method\Common\Required;
use Pckg\Htmlbuilder\Validator\Method\Common\Unique as CommonUnique;
use Pckg\Htmlbuilder\Validator\Method\Csrf;
use Pckg\Htmlbuilder\Validator\Method\Datetime;
use Pckg\Htmlbuilder\Validator\Method\Number;
use Pckg\Htmlbuilder\Validator\Method\Related;
use Pckg\Htmlbuilder\Validator\Method\Text;
use Pckg\Htmlbuilder\Validator\Method\Text\Max;
use Pckg\Htmlbuilder\Validator\Method\Text\Min;
use Pckg\Htmlbuilder\Validator\Method\Unique;

/**
 * Class ValidatorFactory
 *
 * @package Pckg\Htmlbuilder\Validator
 */
class ValidatorFactory extends AbstractFactory
{

    /**
     * @var array
     */
    protected array $mapper = [
        'Csrf'            => Csrf::class,
        'Common'          => Common::class,
        'Common\Required' => Required::class,
        'Common\Unique'   => CommonUnique::class,
        'Common\Matches'  => Matches::class,
        'Text'            => Text::class,
        'Text\Min'        => Min::class,
        'Text\Max'        => Max::class,
        'Number'          => Number::class,
        'Unique'          => Unique::class,
        'Datetime'        => Datetime::class,
        'Related'         => Related::class,
    ];
}
