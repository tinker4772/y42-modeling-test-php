<?php

namespace MJ\ModelingTest\Transformers;

use MJ\ModelingTest\Transformers\TransformObjects\Input as TransformObjectsInput;

class Input extends Base
{
    public function __construct($key, $type, TransformObjectsInput $transformObject, Base $transformer)
    {
        $this->key = $key;
        $this->type = $type;
        $this->transform_object = $transformObject;
        $this->input = $transformer;
    }

    public function getTableName(): string
    {
        return $this->transform_object->tableName;
    }

    public function fields(): array
    {
        return $this->transform_object->fields;
    }

    public function transform(): string
    {
        $tableName = $this->getTableName();
        $fields = implode("`,`", $this->transform_object->fields);

        $query = "SELECT `{$fields}` FROM `{$tableName}`";

        return $query;
    }
}
