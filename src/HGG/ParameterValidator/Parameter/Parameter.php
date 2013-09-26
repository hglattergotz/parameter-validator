<?php

namespace HGG\ParameterValidator\Parameter;

abstract class Parameter
{
    const REQUIRED = true;
    const OPTIONAL = false;

    protected $name;
    protected $isRequired;
    protected $summary;
    protected $description;
    protected $validator;
    protected $defaultValidator;

    /**
     * __construct
     *
     * @param mixed $name
     * @param mixed $isRequired
     * @param mixed $summary
     * @param mixed $description
     * @param bool $validator
     * @access public
     * @return void
     */
    public function __construct($name, $isRequired, $summary, $description, $validator = null)
    {
        $this->name        = $name;
        $this->isRequired  = (boolean) $isRequired;
        $this->summary     = $summary;
        $this->description = $description;
        $this->validator   = $validator;
    }

    abstract protected function getDefaultValidator();

    /**
     * getName
     *
     * @access public
     * @return void
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * getIsRequired
     *
     * @access public
     * @return void
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * getSummary
     *
     * @access public
     * @return void
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * getDescription
     *
     * @access public
     * @return void
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * getValidator
     *
     * @access public
     * @return void
     */
    public function getValidator()
    {
        if (null == $this->validator) {
            return $this->getDefaultValidator();
        } else {
            return $this->validator;
        }
    }
}

