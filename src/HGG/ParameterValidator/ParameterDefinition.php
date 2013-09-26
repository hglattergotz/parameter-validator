<?php

namespace HGG\ParameterValidator;

use HGG\ParameterValidator\Parameter\Parameter;

/**
 * ParameterDefinition
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class ParameterDefinition
{
    /**
     * definitions
     *
     * @var mixed
     * @access protected
     */
    protected $definitions = array();

    protected $required = array();

    /**
     * addParameter
     *
     * @param Parameter $parameter
     * @access public
     * @return void
     */
    public function addParameter(Parameter $parameter)
    {
        if (array_key_exists($parameter->getName(), $this->definitions)) {
            throw new \Exception(sprintf('Parameter with name \'%s\' already exists!', $parameter->getName()));
        }

        $this->definitions[$parameter->getName()] = $parameter;

        if ($parameter->getIsRequired()) {
            $this->required[] = $parameter->getName();
        }

        return $this;
    }

    public function getRequiredParameterNames()
    {
        return $this->required;
    }

    /**
     * getDefinitions
     *
     * @access public
     * @return void
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}
