<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Validator\AbstractGroupValidator;

/**
 * Class Text
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Text extends AbstractGroupValidator
{

    /**
     *
     */
    public function __construct()
    {
        $this->validators = $this->validatorFactory->create([
            'Text\Min',
            'Text\Max',
        ]);
    }

}