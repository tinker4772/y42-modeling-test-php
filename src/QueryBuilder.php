<?php

namespace MJ\ModelingTest;

use MJ\ModelingTest\NodeModel;

class QueryBuilder
{
    public $nodes;
    public $edges;

    public function __construct($json)
    {
        try {
            $nodes = Helper::itemGetter($json, 'nodes');
            $edges = Helper::itemGetter($json, 'edges');

            $this->nodes = new NodeModel($nodes);
            $this->edges = $edges;
        } catch (\Exception $e) {
            throw new \Exception("Must contain both 'nodes' & 'edges'");
        }
    }

    public function build(): ?string
    {
        if (!empty($this->nodes)) {
            $sql = "";
            $transformerClass = new \MJ\ModelingTest\Transformers\Base;

            foreach ($this->nodes as $node) {
                $key = $node['key'];
                $type = $node['type'];
                $transformObj = $node['transformObject'];

                if (strpos($type, "_") !== false) {
                    $typeClass = Helper::ucFirstLetter(Helper::cleanString($type));
                } else {
                    $typeClass = Helper::ucFirstLetter($type);
                }

                if (!class_exists($typeClass)) {
                    $transformerClassName = '\\MJ\\ModelingTest\\Transformers\\' . $typeClass;
                    $objectClassName = '\\MJ\\ModelingTest\\Transformers\\TransformObjects\\' . $typeClass;

                    $transformObject = new $objectClassName($transformObj);
                    $transformerClass = new $transformerClassName($key, $type, $transformObject, $transformerClass);

                    $sql .= "{$key} as (" . $transformerClass->transform() . "),";
                }
            }

            $edge = end($this->edges);
            $result = "WITH " . rtrim($sql, ",");
            $result .= " SELECT * FROM `{$edge['to']}`";
        }

        return $result;
    }
}
