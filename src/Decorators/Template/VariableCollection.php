<?php

namespace CheckItOnUs\Cachet\Decorators\Template;

use ArrayAccess;
use CheckItOnUs\Cachet\Traits\HasMetadata;

class VariableCollection implements ArrayAccess
{
    use HasMetadata;

    /**
     * Retrieves the complete list of variables
     *
     * @return     array
     */
    public function all()
    {
        return $this->getMetadata();
    }
}