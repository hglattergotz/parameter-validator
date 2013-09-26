<?php

namespace HGG\ParameterValidator\Parameter\Validator;

class NumberValidator implements Validator
{
    public function validate($value)
    {
        if (!is_numeric($value)) {
            throw new \Exception(sprintf('The value \'%s\' is not a number', $value));
        }

        return $value;
    }
}
