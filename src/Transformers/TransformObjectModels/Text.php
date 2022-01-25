<?php

namespace MJ\ModelingTest\Transformers\TransformObjectModels;

use MJ\ModelingTest\Transformers\TransformObjects\Text as TransformObjectsText;
use Rutek\Dataclass\Collection;

class Text extends Collection
{
    public string $key;
    public string $type;
    public TransformObjectsText $transformObject;
}

