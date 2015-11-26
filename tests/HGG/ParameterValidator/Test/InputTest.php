<?php

namespace HGG\ParameterValidator\Test;

use HGG\ParameterValidator\Parameter\Parameter;
use HGG\ParameterValidator\Parameter\NumberParameter;
use HGG\ParameterValidator\Parameter\TextParameter;
use HGG\ParameterValidator\Parameter\TextArrayParameter;
use HGG\ParameterValidator\Parameter\DateParameter;
use HGG\ParameterValidator\Parameter\DatetimeParameter;
use HGG\ParameterValidator\Parameter\BooleanParameter;
use HGG\ParameterValidator\ParameterDefinition;
use HGG\ParameterValidator\Input;

/**
 * InputTest
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class InputTest extends \PHPUnit_Framework_TestCase
{
    /**
     * def
     *
     * @var mixed
     * @access protected
     */
    protected $def;

    /**
     * setUp
     *
     * @access protected
     * @return void
     */
    protected function setUp()
    {
        $this->def = new ParameterDefinition();
        $this->def
            ->addParameter(
                new NumberParameter(
                    'req-num',
                    Parameter::REQUIRED,
                    'This is a required numeric parameter',
                    'Some more details could go here'
                )
            )
            ->addParameter(
                new TextParameter(
                    'opt-txt',
                    Parameter::OPTIONAL,
                    'This is an optional text parameter',
                    'Some more details could go here'
                )
            )
            ->addParameter(
                new TextParameter(
                    'opt-txt-array',
                    Parameter::OPTIONAL,
                    'This is an optional text array parameter',
                    'Some more details could go here'
                )
            )
            ->addParameter(
                new DateParameter(
                    'opt-date',
                    Parameter::OPTIONAL,
                    'This is an optional date parameter',
                    'Some more details could go here'
                )
            )
            ->addParameter(
                new DatetimeParameter(
                    'opt-datetime',
                    Parameter::OPTIONAL,
                    'This is an optinal datetime parameter',
                    'Some more details could go here'
                )
            )
            ->addParameter(
                new BooleanParameter(
                    'opt-bool',
                    Parameter::OPTIONAL,
                    'This is an optinal boolean parameter',
                    'Some more details could go here'
                )
            );
    }

    /**
     * tearDown
     *
     * @access protected
     * @return void
     */
    protected function tearDown()
    {}

    /**
     * testParamterAlreadyExists
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Parameter with name 'req-num' already exists!
     *
     * @access public
     * @return void
     */
    public function testParamterAlreadyExists()
    {
        $def = $this->def
                    ->addParameter(
                        new NumberParameter(
                            'req-num',
                            Parameter::REQUIRED,
                            'This is a required numeric parameter',
                            'Some more details could go here'
                        )
                    );
    }

    /**
     * testParameterGetters
     *
     * @access public
     * @return void
     */
    public function testParameterGetters()
    {
        $numberParameter = new NumberParameter(
            'req-num',
            Parameter::REQUIRED,
            'This is a required numeric parameter',
            'Some more details could go here',
            'RandomValidatorClass'
        );

        $this->assertEquals('This is a required numeric parameter', $numberParameter->getSummary());
        $this->assertEquals('Some more details could go here', $numberParameter->getDescription());
        $this->assertEquals('RandomValidatorClass', $numberParameter->getValidator());
    }

    /**
     * testSunnyDay
     *
     * @access public
     * @return void
     */
    public function testSunnyDay()
    {
        $parameters = array(
            'req-num'       => 1234,
            'opt-txt'       => 'Some text value',
            'opt-txt-array' => array('type' => 'Some text value on index 0'),
            'opt-date'      => '2000-01-01',
            'opt-datetime'  => '2000-01-01 23:00:00',
            'opt-bool'      => true
        );

        $input = new Input($parameters, $this->def);
        $result = $input->getParameters();
        $expected = $parameters;

        $this->assertEquals($expected, $result);
    }

    /**
     * testOmitOptionalParameter
     *
     * @access public
     * @return void
     */
    public function testOmitOptionalParameter()
    {
        $parameters = array(
            'req-num' => 1234
        );

        $input = new Input($parameters, $this->def);
        $result = $input->getParameters();
        $expected = $parameters;

        $this->assertEquals($expected, $result);
    }

    /**
     * testOmitRequiredParameter
     *
     * @expectedException        Exception
     * @expectedExceptionMessage The required parameter 'req-num' is missing
     *
     * @access public
     * @return void
     */
    public function testOmitRequiredParameter()
    {
        $parameters = array(
            'opt-txt' => 'Some text value'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testOmitRequiredParameters
     *
     * @expectedException        Exception
     * @expectedExceptionMessage The required parameters 'req-num', 'req-num-2' are missing
     *
     * @access public
     * @return void
     */
    public function testOmitRequiredParameters()
    {
        $def = $this->def->addParameter(
            new NumberParameter(
                'req-num-2',
                Parameter::REQUIRED,
                'This is a required numeric parameter',
                'Some more details could go here'
            )
        );

        $parameters = array(
            'opt-txt' => 'Some text value'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testAddUndefinedParameter
     *
     * @expectedException        Exception
     * @expectedExceptionMessage The parameter 'not-defined' is not valid
     *
     * @access public
     * @return void
     */
    public function testAddUndefinedParameter()
    {
        $parameters = array(
            'req-num'     => 1234,
            'not-defined' => 12
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testAddUndefinedParameters
     *
     * @expectedException        Exception
     * @expectedExceptionMessage The parameters 'not-defined', 'not-defined-2', 'not-defined-3' are not valid
     *
     * @access public
     * @return void
     */
    public function testAddUndefinedParameters()
    {
        $parameters = array(
            'req-num'     => 1234,
            'not-defined' => 12,
            'not-defined-2' => 12,
            'not-defined-3' => 12
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testIncorrectParameterTypeNumber
     *
     * @expectedException Exception
     *
     * @access public
     * @return void
     */
    public function testIncorrectParameterTypeNumber()
    {
        $parameters = array(
            'req-num' => 'this-is-not-a-number'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testIncorrectParameterTypeText
     *
     * @expectedException Exception
     *
     * @access public
     * @return void
     */
    public function testIncorrectParameterTypeText()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-txt' => true
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testIncorrectParameterTypeDate
     *
     * @expectedException Exception
     *
     * @access public
     * @return void
     */
    public function testIncorrectParameterTypeDate()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-date' => 'this is not a date'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testIncorrectParameterTypeDateTime
     *
     * @expectedException Exception
     *
     * @access public
     * @return void
     */
    public function testIncorrectParameterTypeDateTime()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-datetime' => 'this is not a datetime'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testIncorrectParameterTypeBoolean
     *
     * @expectedException Exception
     *
     * @access public
     * @return void
     */
    public function testIncorrectParameterTypeBoolean()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-bool' => 'this is not a boolean'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * testAllTrueBooleanPrameterValues
     *
     * @dataProvider allTrueBooleanDataProvider
     *
     * @param mixed $parameters
     * @access public
     * @return void
     */
    public function testAllTrueBooleanPrameterValues($parameters)
    {
        $expected = array(
            'req-num'      => 1234,
            'opt-txt'      => 'Some text value',
            'opt-date'     => '2000-01-01',
            'opt-datetime' => '2000-01-01 23:00:00',
            'opt-bool'     => true
        );

        $input = new Input($parameters, $this->def);
        $result = $input->getParameters();

        $this->assertEquals($expected, $result);
    }

    /**
     * allTrueBooleanDataProvider
     *
     * @access public
     * @return void
     */
    public function allTrueBooleanDataProvider()
    {
        $data = array(
                'req-num'      => 1234,
                'opt-txt'      => 'Some text value',
                'opt-date'     => '2000-01-01',
                'opt-datetime' => '2000-01-01 23:00:00',
                'opt-bool'     => true
            );

        $allBools = array(true, 'true', 'yes', 'on', '1', 1);

        $result = array();

        foreach ($allBools as $boolVal) {
            $data['opt-bool'] = $boolVal;
            $result[] = array($data);
        }

        return $result;
    }

    /**
     * testAllFalseBooleanPrameterValues
     *
     * @dataProvider allFalseBooleanDataProvider
     *
     * @param mixed $parameters
     * @access public
     * @return void
     */
    public function testAllFalseBooleanPrameterValues($parameters)
    {
        $expected = array(
            'req-num'      => 1234,
            'opt-txt'      => 'Some text value',
            'opt-date'     => '2000-01-01',
            'opt-datetime' => '2000-01-01 23:00:00',
            'opt-bool'     => false
        );

        $input = new Input($parameters, $this->def);
        $result = $input->getParameters();

        $this->assertEquals($expected, $result);
    }

    /**
     * allFalseBooleanDataProvider
     *
     * @access public
     * @return void
     */
    public function allFalseBooleanDataProvider()
    {
        $data = array(
                'req-num'      => 1234,
                'opt-txt'      => 'Some text value',
                'opt-date'     => '2000-01-01',
                'opt-datetime' => '2000-01-01 23:00:00',
                'opt-bool'     => false
            );

        $allBools = array(false, "false", 'no', '0', 0);

        $result = array();

        foreach ($allBools as $boolVal) {
            $data['opt-bool'] = $boolVal;
            $result[] = array($data);
        }

        return $result;
    }
}
