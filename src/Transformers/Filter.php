<?php

namespace MJ\ModelingTest\Transformers;

use MJ\ModelingTest\Transformers\TransformObjects\Filter as TransformObjectsFilter;

class Filter extends Base
{
    public function __construct($key, $type, TransformObjectsFilter $transformObject, Base $transformer)
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

    public function isValidField(): bool
    {
        if (in_array($this->transform_object->variable_field_name, $this->input->fields())) {
            return true;
        }

        return false;
    }

    public function whereClause(): string
    {
        $query = "";
        $field = $this->transform_object->variable_field_name;
        $joinOperator = $this->transform_object->joinOperator;
        $operations = $this->transform_object->operations;

        foreach ($operations as $values) {
            if (!empty($query)) {
                $query .= " {$joinOperator} ";
            }

            if (isset($values['operator']) && isset($values['value'])) {
                $query .= "{$field} {$values['operator']} {$values['value']}";
            }
        }

        return trim($query);
    }

    public function transform(): string
    {
        if (!$this->isValidField()) {
            throw new \Exception(" {$this->transform_object->variable_field_name} is not valid column name");
        }

        $edge = $this->input->key;
        $fields = implode("`,`", $this->input->fields());

        $sql = "SELECT `{$fields}` FROM `{$edge}`";
        $where = " WHERE " . $this->whereClause();
        $query = $sql . $where;

        return $query;
    }
}
