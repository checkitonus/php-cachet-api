<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;
use CheckItOnUs\Cachet\Traits\HasMetadata;

class Configuration implements ArrayAccess
{
    use HasMetadata;

    /**
     * Initialize and hydrate the configuration object.
     *
     * @param      array  $values  The values
     */
    public function __construct($values = [])
    {
        // Ensure the data for the configuration is correct
        if(!empty($values) && is_array($values)) {
            // It is, so populate it
            $this->setMetadata($values);
        }
    }
}