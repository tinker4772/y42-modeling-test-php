<?php

namespace MJ\ModelingTest\Transformers\TransformObjectModels;

use MJ\ModelingTest\Transformers\TransformObjects\Filter as TransformObjectsFilter;
use Rutek\Dataclass\Collection;

class Filter extends Collection
{
    public string $key;
    public string $type;
    public TransformObjectsFilter $transformObject;
}
