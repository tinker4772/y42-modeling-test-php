<?php

namespace MJ\ModelingTest\Transformers\TransformObjectModels;

use MJ\ModelingTest\Transformers\TransformObjects\Sort as TransformObjectsSort;
use Rutek\Dataclass\Collection;

class Sort extends Collection
{
    public string $key;
    public string $type;
    public TransformObjectsSort $transformObject;
}

