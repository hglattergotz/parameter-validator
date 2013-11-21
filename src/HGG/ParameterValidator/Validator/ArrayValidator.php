<?php

namespace HGG\ParameterValidator\Validator;

class ArrayValidator
{
    public static function contains(array $haystack, $required = array(), $optional = array(), $allowUnspecified = false)
    {
        self::checkForIntersect($required, $optional);
        self::checkRequired($haystack, $required);
        self::checkOptional($haystack, $required, $optional, $allowUnspecified);

        return true;
    }

    static protected function checkForIntersect($required, $optional)
    {
        $intersection = array_intersect($required, $optional);

        if (0 !== count($intersection)) {
            $msg = 'The parameter%s %s %s both required and optional. This is not allowed.';
            $singular = (1 === count($intersection)) ? true : false;
            $keyString = implode(', ', $intersection);

            throw new \Exception(sprintf($msg, $singular ? '' : 's', $keyString, $singular ? 'is' : 'are'));
        }
    }

    static protected function checkRequired($haystack, $required)
    {
        $intersection = array_intersect_key(array_flip($required), array_flip($haystack));

        if (count($intersection) !== count($required)) {
            $msg = 'The required parameter%s %s %s missing.';
            $missing = array_diff($required, array_flip($intersection));
            $singular = (1 === count($missing)) ? true : false;
            $keyString = implode(', ', $missing);

            throw new \Exception(sprintf($msg, $singular ? '' : 's', $keyString, $singular ? 'is' : 'are'));
        }
    }

    static protected function checkOptional($haystack, $required, $optional, $allowUnspecified)
    {
        $actualOptional = array_diff($haystack, $required);
        $extra = array_diff($actualOptional, $optional);

        if (0 < count($extra) && !$allowUnspecified) {
            $msg = 'The paramete%s %s %s not valid.';
            $singular = (1 === count($extra)) ? true : false;
            $keyString = implode(', ', $extra);

            throw new \Exception(sprintf($msg, $singular ? '' : 's', $keyString, $singular ? 'is' : 'are'));
        }
    }
}
