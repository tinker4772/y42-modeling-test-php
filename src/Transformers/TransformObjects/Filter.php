<?php

namespace MJ\ModelingTest\Transformers\TransformObjects;

class Filter
{
    public $variable_field_name;
    public $joinOperator;
    public $operations;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
