<?php

namespace MJ\ModelingTest\Transformers\TransformObjects;

class Output
{
    public $limit;
    public $offset;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
