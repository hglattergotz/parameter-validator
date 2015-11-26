<?php

namespace HGG\ParameterValidator\Parameter;

use HGG\ParameterValidator\Parameter\Validator\TextValidator;

/**
 * TextParameter
 *
 * @uses Parameter
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class TextParameter extends Parameter
{
    /**
     * getDefaultValidator
     *
     * @access protected
     * @return void
     */
    protected function getDefaultValidator()
    {
        return new TextValidator();
    }
}
