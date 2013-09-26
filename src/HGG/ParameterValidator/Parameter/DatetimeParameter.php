<?php

namespace HGG\ParameterValidator\Parameter;

use HGG\ParameterValidator\Parameter\Validator\DatetimeValidator;

class DatetimeParameter extends Parameter
{
    protected function getDefaultValidator()
    {
        return new DatetimeValidator();
    }
}
