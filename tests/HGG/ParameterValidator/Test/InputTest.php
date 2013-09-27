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

    public function testOmitRequiredParameter()
    {
        $parameters = array(
            'opt-txt' => 'Some text value'
        );

        $this->setExpectedException('Exception');
        $input = new Input($parameters, $this->def);
    }

    public function testAddUndefinedParameter()
    {
        $parameters = array(
            'req-num'     => 1234,
            'not-defined' => 12
        );

        $this->setExpectedException('Exception');
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
}

