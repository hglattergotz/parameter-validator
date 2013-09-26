<?php

namespace HGG\ParameterValidator\Parameter;

use HGG\ParameterValidator\Parameter\Validator\DateValidator;

class DateParameter extends Parameter
{
    protected function getDefaultValidator()
    {
        return new DateValidator();
    }
}
