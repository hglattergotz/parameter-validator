<?php

namespace HGG\ParameterValidator\Parameter\Validator;

class TextValidator implements Validator
{
    public function validate($value)
    {
        if (!is_string($value)) {
            throw new \Exception(sprintf('The value \'%s\' is not of type text', $value));
        }

        return $value;
    }
}
