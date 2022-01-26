<?php

namespace MJ\ModelingTest\Transformers;

use MJ\ModelingTest\Transformers\TransformObjects\Output as TransformObjectsOutput;

class Output extends Base
{
    public function __construct($key, $type, TransformObjectsOutput $transformObject, Base $transformer)
    {
        $this->key = $key;
        $this->type = $type;
        $this->transform_object = $transformObject;
        $this->input = $transformer;
    }

    public function fields()
    {
        return $this->input->fields();
    }

    public function limitClause(): string
    {
        $offset = $this->transform_object->offset;
        $limit = $this->transform_object->limit;
        $query = "{$offset}, {$limit}";

        return $query;
    }

    public function transform()
    {
        $edge = $this->input->key;

        $sql = "SELECT * FROM `{$edge}`";
        $limit = " LIMIT " . $this->limitClause();

        $query = $sql . $limit;

        return $query;
    }
}
