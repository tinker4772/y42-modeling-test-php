<?php

namespace MJ\ModelingTest\Transformers;

use MJ\ModelingTest\Transformers\TransformObjects\Sort as TransformObjectsSort;

class Sort extends Base
{
    public function __construct($key, $type, TransformObjectsSort $transformObject, Base $transformer)
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

    public function isValidFields(): array
    {
        $fields = array();
        $targets = array_column((array) $this->transform_object, 'target');

        foreach ($targets as $field) {
            if (!in_array($field, $this->input->fields())) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    public function orderByClause(): string
    {
        $query = "";
        $list = $this->transform_object;

        foreach ($list as $values) {
            if (isset($values['target']) && isset($values['order'])) {
                $query .= "{$values['target']} {$values['order']} ";
            }
        }

        return trim($query);
    }

    public function transform()
    {
        if ($fields = $this->isValidFields()) {
            $names = implode(", ", $fields);
            throw new \Exception("{$names} not valid columns");
        }

        $sql = $this->input->transform();
        $orderBy = " ORDER BY " . $this->orderByClause();

        $query = $sql . $orderBy;

        return $query;
    }
}
