<?php

namespace HGG\ParameterValidator\Parameter;

use HGG\ParameterValidator\Parameter\Validator\NumberValidator;

class NumberParameter extends Parameter
{
    protected function getDefaultValidator()
    {
        return new NumberValidator();
    }
}
