<?php

use MJ\ModelingTest\QueryBuilder;

require __DIR__ . '/vendor/autoload.php';

$json = "./request-data.json";
$jsonObject = json_decode(file_get_contents($json), true);

$builder = new QueryBuilder($jsonObject);
$builder->build();


