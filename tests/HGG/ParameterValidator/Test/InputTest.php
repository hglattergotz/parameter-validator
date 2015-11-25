<?php

namespace HGG\ParameterValidator\Test;

use HGG\ParameterValidator\Parameter\Parameter;
use HGG\ParameterValidator\Parameter\NumberParameter;
use HGG\ParameterValidator\Parameter\TextParameter;
use HGG\ParameterValidator\Parameter\DateParameter;
use HGG\ParameterValidator\Parameter\DatetimeParameter;
use HGG\ParameterValidator\Parameter\BooleanParameter;
use HGG\ParameterValidator\ParameterDefinition;
use HGG\ParameterValidator\Input;

class InputTest extends \PHPUnit_Framework_TestCase
{
    protected $def;

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

    protected function tearDown()
    {}

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Parameter with name 'req-num' already exists!
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

    public function testSunnyDay()
    {
        $parameters = array(
            'req-num'      => 1234,
            'opt-txt'      => 'Some text value',
            'opt-date'     => '2000-01-01',
            'opt-datetime' => '2000-01-01 23:00:00',
            'opt-bool'     => true
        );

        $input = new Input($parameters, $this->def);
        $result = $input->getParameters();
        $expected = $parameters;

        $this->assertEquals($expected, $result);
    }

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
     * @expectedException        Exception
     * @expectedExceptionMessage The required parameter 'req-num' is missing
     */
    public function testOmitRequiredParameter()
    {
        $parameters = array(
            'opt-txt' => 'Some text value'
        );

        $input = new Input($parameters, $this->def);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage The required parameters 'req-num', 'req-num-2' are missing
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
     * @expectedException        Exception
     * @expectedExceptionMessage The parameter 'not-defined' is not valid
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
     * @expectedException        Exception
     * @expectedExceptionMessage The parameters 'not-defined', 'not-defined-2', 'not-defined-3' are not valid
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

    public function testIncorrectParameterTypeNumber()
    {
        $parameters = array(
            'req-num' => 'this-is-not-a-number'
        );

        $this->setExpectedException('Exception');
        $input = new Input($parameters, $this->def);
    }

    public function testIncorrectParameterTypeText()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-txt' => true
        );

        $this->setExpectedException('Exception');
        $input = new Input($parameters, $this->def);
    }

    public function testIncorrectParameterTypeDate()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-date' => 'this is not a date'
        );

        $this->setExpectedException('Exception');
        $input = new Input($parameters, $this->def);
    }

    public function testIncorrectParameterTypeDateTime()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-datetime' => 'this is not a datetime'
        );

        $this->setExpectedException('Exception');
        $input = new Input($parameters, $this->def);
    }

    public function testIncorrectParameterTypeBoolean()
    {
        $parameters = array(
            'req-num' => 1234,
            'opt-bool' => 'this is not a boolean'
        );

        $this->setExpectedException('Exception');
        $input = new Input($parameters, $this->def);
    }

    /**
     * @dataProvider allTrueBooleanDataProvider
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
     * @dataProvider allFalseBooleanDataProvider
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
