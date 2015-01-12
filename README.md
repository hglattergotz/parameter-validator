Framework for specifying and enforcing rules on key/value pairs

[![Build Status](https://travis-ci.org/hglattergotz/parameter-validator.svg)](https://travis-ci.org/hglattergotz/parameter-validator)
[![Latest Stable Version](https://poser.pugx.org/hgg/parameter-validator/v/stable.svg)](https://packagist.org/packages/hgg/parameter-validator)
[![Total Downloads](https://poser.pugx.org/hgg/parameter-validator/downloads.svg)](https://packagist.org/packages/hgg/parameter-validator)
[![License](https://poser.pugx.org/hgg/parameter-validator/license.svg)](https://packagist.org/packages/hgg/parameter-validator)

## Installation

Using Composer:

```json
{
    "require": {
        "hgg/parameter-validator": "dev-master"
    }
}
```

## Use Cases

### Url Query String Parameters

A framework like Symfony 2 provides the Request object from which one can obtain
the query string parameters either one by one

```php
$param = $request->query->get('name-of-parameter');
```

or all at once

```php
$params = $request->query->all();
```

This is really convenient but the validation of these parameters is still left
to the developer and becomes really tedious.
You still have to ensure that all required parameters are present and that the
values for them are of the correct type, etc.

This framework allows the definition of rules for the parameters and can even
validate the values for these parameters.

## Example - Url Query String Parameter Validation in Symfony 2

SomeApiMethod.php
```php
<?php

namespace HGG\ParameterValidator\Test;

use HGG\ParameterValidator\Parameter\NumberParameter;
use HGG\ParameterValidator\ParameterDefinition;
use HGG\ParameterValidator\Input;

class SomeApiMethod
{
    protected $def;

    public function __construct()
    {
        $this->def = new ParameterDefinition();
        $this->def
            ->addParameter(
                new NumberParameter(
                    'id',
                    Parameter::REQUIRED,
                    'This is a required numeric parameter',
                    'Some more details could go here'
                )
            );
    }

    public function execute($parameters)
    {
        $input = new Input($parameters, $this->def);

        $validatedParameters = $input->getParameters();

        // Do some work here and create a result

        return $result;
    }
}
```

SomeController.php
```php
<?php

class SomeController
{
    public function someAction()
    {
        $method = new SomeApiMethod();

        return $method->execute($this->getRequest()->query->all());
    }
}
```
