<?php

namespace HGG\ParameterValidator\Parameter;

use HGG\ParameterValidator\Parameter\Validator\TextValidator;

class TextParameter extends Parameter
{
    protected function getDefaultValidator()
    {
        return new TextValidator();
    }
}
