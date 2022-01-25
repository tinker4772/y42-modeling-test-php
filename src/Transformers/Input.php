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

    public function getColumns()
    {
        return implode(", ", $this->transform_object->fields);
    }

    public function getTableName()
    {
        return $this->transform_object->tableName;
    }

    public function fields()
    {
        return $this->transform_object->fields;
    }

    public function transform()
    {
        $cols = $this->getColumns();
        $tableName = $this->getTableName();

        $query = "SELECT {$cols} FROM {$tableName}";

        return trim($query);
    }
}
