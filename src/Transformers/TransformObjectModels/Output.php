<?php

namespace MJ\ModelingTest\Transformers\TransformObjectModels;

use MJ\ModelingTest\Transformers\TransformObjects\Output as TransformObjectsOutput;
use Rutek\Dataclass\Collection;

class Output extends Collection
{
    public string $key;
    public string $type;
    public TransformObjectsOutput $transformObject;
}

