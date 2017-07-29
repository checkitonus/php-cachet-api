<?php

namespace CheckItOnUs\Cachet\Decorators\Template;

use ArrayAccess;
use CheckItOnUs\Cachet\Traits\HasMetadata;

class VariableCollection implements ArrayAccess
{
    use HasMetadata;

    public function all()
    {
        return $this->getMetadata();
    }
}