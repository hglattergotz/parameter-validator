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
     * Array of parameter objects that make up the definition
     *
     * @var mixed
     * @access protected
     */
    protected $definitions = array();

    /**
     * List of required parameters
     *
     * @var array
     * @access protected
     */
    protected $required = array();

    /**
     * Add a new parameter object to the definition
     *
     * @param Parameter $parameter
     * @access public
     *
     * @return $this
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

    /**
     * Gets a list of required parameters
     *
     * @access public
     *
     * @return array
     */
    public function getRequiredParameterNames()
    {
        return $this->required;
    }

    /**
     * Gets all the loaded definitions (Parameter objects)
     *
     * @access public
     *
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}
