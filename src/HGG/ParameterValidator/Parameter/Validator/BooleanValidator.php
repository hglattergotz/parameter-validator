<?php

namespace HGG\ParameterValidator\Parameter\Validator;

class BooleanValidator implements Validator
{
    public function validate($value)
    {
        $raw = $value;
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (null == $value) {
            throw new \Exception(sprintf('The value \'%s\' is not of type boolean', $raw));
        }

        return $value;
    }
}
