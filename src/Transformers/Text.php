<?php

namespace MJ\ModelingTest\Transformers;

use MJ\ModelingTest\Transformers\TransformObjects\Text as TransformObjectsText;

class Text extends Base
{
    public function __construct($key, $type, TransformObjectsText $transformObject, Base $transformer)
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
        $columns = array_column((array) $this->transform_object, 'column');

        foreach ($columns as $field) {
            if (!in_array($field, $this->input->fields())) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    public function columnTransformation()
    {
        $query = "";
        $fields = $this->input->fields();
        $list = $this->transform_object;

        foreach ($list as $key => $values) {
            if (isset($values['transformation']) && isset($values['column'])) {
                $key = array_search($values['column'], $fields);
                $stmt = "{$values['transformation']} (`{$values['column']}`) as `{$values['column']}`";
                unset($fields[$key]);
                array_push($fields, $stmt);
            }
        }

        return implode(", ", $fields);
    }

    public function transform()
    {
        if ($fields = $this->isValidFields()) {
            $names = implode(", ", $fields);
            throw new \Exception("{$names} not valid columns");
        }

        $edge = $this->input->key;
        $transformation = $this->columnTransformation();

        $query = "SELECT {$transformation} FROM `{$edge}`";

        return $query;
    }
}
