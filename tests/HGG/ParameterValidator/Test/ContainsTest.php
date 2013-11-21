<?php

namespace HGG\ParameterValidator\Test;

use HGG\ParameterValidator\Validator\ArrayValidator as v;

class ContainsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider allPassDataProvider
     */
    public function testPass($haystack, $required, $optional, $allowUnspecified)
    {
        $this->assertTrue(v::contains($haystack, $required, $optional, $allowUnspecified));
    }

    public function allPassDataProvider()
    {
        return array(
            array(
                array('a'),
                array(),
                array('a', 'b', 'c'),
                false
            ),
            array(
                array('a', 'b', 'c'),
                array(),
                array('a', 'b', 'c'),
                false
            ),
            array(
                array('a'),
                array(),
                array('b', 'c'),
                true
            ),
            array(
                array('a'),
                array('a'),
                array(),
                false
            ),
            array(
                array('a'),
                array('a'),
                array('b', 'c'),
                false
            ),
            array(
                array('a', 'b', 'c'),
                array('a'),
                array('b', 'c'),
                false
            ),
            array(
                array('a', 'b', 'c', 'd'),
                array('a'),
                array('b', 'c'),
                true
            )
        );
    }

    /**
     * @dataProvider allFailDataProvider
     */
    public function testFail($haystack, $required, $optional, $allowUnspecified)
    {
        try {
            v::contains($haystack, $required, $optional, $allowUnspecified);
            $this->fail('Expected exception not raised.');
        } catch (\Exception $e) {
            return;
        }
    }

    public function allFailDataProvider()
    {
        return array(
            array(
                array('a', 'b', 'c'),
                array(),
                array('a', 'b'),
                false
            ),
            array(
                array('b', 'c'),
                array('a'),
                array('b', 'c'),
                false
            ),
            array(
                array('a', 'b', 'c'),
                array('a'),
                array('a', 'c'),
                false
            ),
            array(
                array('a', 'b', 'c'),
                array('a', 'b'),
                array(),
                false
            )
        );
    }
}
