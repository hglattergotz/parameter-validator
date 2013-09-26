<?php

namespace HGG\ParameterValidator\Parameter\Validator;

class DatetimeValidator implements Validator
{
    public function validate($value)
    {
        $ts = strtotime($value);

        if (-1 === $ts || false === $ts) {
            throw new \Exception(sprintf('The value \'%s\' is not a datetime type', $value));
        }

        return $value;
    }
}
