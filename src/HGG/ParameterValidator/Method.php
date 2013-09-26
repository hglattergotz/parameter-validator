<?php

namespace HGG\ParameterValidator;

/**
 * Method
 *
 * @abstract
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
abstract class Method
{
    const GET  = 'GET';
    const PUT  = 'PUT';
    const POST = 'POST';

    protected $route;
    protected $type;
    protected $summary;
    protected $description;
    protected $parameters;
    protected $definitions;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->definitions = new ParameterDefinition();
        $this->configure();
    }

    /**
     * configure
     *
     * @abstract
     * @access protected
     * @return void
     */
    abstract protected function configure();

    /**
     * doExecute
     *
     * @param mixed $parameters
     * @abstract
     * @access protected
     * @return void
     */
    abstract protected function doExecute($parameters);

    /**
     * execute
     *
     * @param mixed $queryStringParameters
     * @access public
     * @return void
     */
    public function execute($queryStringParameters)
    {
        $input = new Input($queryStringParameters, $this->definitions);
        $parameters = $input->getParameters();

        return $this->doExecute($parameters);
    }

    protected function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    protected function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    protected function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    protected function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * addParameter
     *
     * @param mixed $name
     * @param mixed $type
     * @param mixed $isRequired
     * @param mixed $summary
     * @param mixed $description
     * @access public
     * @return void
     */
    public function addParameter($name, $type, $isRequired, $summary, $description)
    {
        $this->definitions->addParameter(new Parameter($name, $type, $isRequired, $summary, $description));

        return $this;
    }

    /**
     * getParameters
     *
     * @param mixed $request
     * @access protected
     * @return void
     */
    protected function getParameters($request)
    {
        foreach ($this->parameters as $param) {

        }
    }
}
