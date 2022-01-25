<?php

namespace MJ\ModelingTest\Transformers\TransformObjectModels;

use MJ\ModelingTest\Transformers\TransformObjects\Input as TransformObjectsInput;
use Rutek\Dataclass\Collection;

class Input extends Collection
{
    public string $key;
    public string $type;
    public TransformObjectsInput $transformObject;
}
