<?php

namespace HGG\ParameterValidator;

/**
 * Input
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class Input
{
    /**
     * rawParams
     *
     * @var mixed
     * @access protected
     */
    protected $rawParams;

    /**
     * parsedParams
     *
     * @var mixed
     * @access protected
     */
    protected $parsedParams;

    /**
     * requiredParams
     *
     * @var mixed
     * @access protected
     */
    protected $requiredParams;

    /**
     * __construct
     *
     * @param mixed $request
     * @param ParameterDefinition $definition
     * @access public
     *
     * @return void
     */
    public function __construct($parameters, ParameterDefinition $definition)
    {
        $this->rawParams = $parameters;
        $this->requiredParams = $definition->getRequiredParameterNames();
        $this->parse($definition->getDefinitions());
    }

    /**
     * Return the array of parsed parameters
     *
     * @access public
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parsedParams;
    }

    /**
     * Parse the passed in parameters and ensure that they conform to the
     * definition
     *
     * @param array $definitions
     * @access protected
     *
     * @return void
     */
    protected function parse(array $definitions)
    {
        foreach ($this->rawParams as $rKey => $rVal) {
            if (array_key_exists($rKey, $definitions)) {
                $value = $this->validateValue($rVal, $definitions[$rKey]);
                $this->parsedParams[$rKey] = $value;
                unset($this->rawParams[$rKey]);

                if ($definitions[$rKey]->getIsRequired()) {
                    unset($this->requiredParams[array_search($rKey, $this->requiredParams)]);
                }
            }
        }

        $this->handleUndefinedParameters();
        $this->handleMissingRequiredParameters();
    }

    /**
     * Throw an exception if a parameter that is not in the definition was
     * passed in the parameter array
     *
     * @access private
     * @throw Exception
     *
     * @return void
     */
    private function handleUndefinedParameters()
    {
        $leftover = count($this->rawParams);

        if (0 < $leftover) {
            if (1 == $leftover) {
                $msg = 'The parameter \'%s\' is not valid';
            } else {
                $msg = 'The parameters \'%s\' are not valied';
            }

            throw new \Exception(sprintf($msg, implode('\', \'', array_keys($this->rawParams))));
        }
    }

    /**
     * Throw an exception if a required parameter is missing
     *
     * @access private
     * @throw Exception
     *
     * @return void
     */
    private function handleMissingRequiredParameters()
    {
        $leftover = count($this->requiredParams);

        if (0 < $leftover) {
            if (1 == $leftover) {
                $msg = 'The required parameter \'%s\' is missing';
            } else {
                $msg = 'The required parameters \'%s\' are missing';
            }

            throw new \Exception(sprintf($msg, implode('\', \'', $this->requiredParams)));
        }
    }

    /**
     * Run the value through the configured validator
     *
     * @param mixed $value
     * @param Parameter $definition
     * @access protected
     *
     * @throw Exception
     *
     * @return mixed
     */
    protected function validateValue($value, $definition)
    {
        try
        {
            return $definition->getValidator()->validate($value);
        }
        catch (\Exception $e)
        {
            throw new \Exception(sprintf('[%s] %s', $definition->getName(), $e->getMessage()));
        }
    }
}
