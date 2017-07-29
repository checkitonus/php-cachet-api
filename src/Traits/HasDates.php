<?php

namespace CheckItOnUs\Cachet\Traits;

use Carbon\Carbon;

trait HasDates
{
    /**
     * Converts the created_at attribute to a date
     *
     * @param      string  $value  The value
     */
    public function setCreatedAt($value)
    {
        $this->_metadata['created_at'] = empty($value) ? null : Carbon::parse($value);
    }

    /**
     * Converts the updated_at attribute to a date
     *
     * @param      string  $value  The value
     */
    public function setUpdatedAt($value)
    {
        $this->_metadata['updated_at'] = empty($value) ? null : Carbon::parse($value);
    }

}