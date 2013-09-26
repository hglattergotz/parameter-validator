<?php

namespace HGG\ParameterValidator\Parameter;

use HGG\ParameterValidator\Parameter\Validator\BooleanValidator;

class BooleanParameter extends Parameter
{
    protected function getDefaultValidator()
    {
        return new BooleanValidator();
    }
}
