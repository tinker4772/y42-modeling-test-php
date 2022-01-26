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

    public function orderByClause(): ?string
    {
        $order = [];
        $list = $this->transform_object;

        foreach ($list as $values) {
            if (isset($values['target']) && isset($values['order'])) {
                $order[] = "{$values['target']} {$values['order']}";
            }
        }

        $query = implode(",", $order);

        return $query;
    }

    public function transform()
    {
        if ($fields = $this->isValidFields()) {
            $names = implode(", ", $fields);
            throw new \Exception("{$names} not valid columns");
        }

        $edge = $this->input->key;
        $fields = implode("`,`", $this->input->fields());

        $sql = "SELECT `{$fields}` FROM `{$edge}`";
        $orderBy = " ORDER BY " . $this->orderByClause();
        $query = $sql . $orderBy;

        return $query;
    }
}
