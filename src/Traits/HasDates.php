<?php

namespace CheckItOnUs\Cachet\Traits;

use Carbon\Carbon;
use CheckItOnUs\Cachet\Decorators\Date;

trait HasDates
{
    /**
     * Converts the created_at attribute to a date
     *
     * @param      string  $value  The value
     */
    public function setCreatedAt($value)
    {
        $this->_metadata['created_at'] = $this->deriveDate($value);

        return $this;
    }

    /**
     * Converts the updated_at attribute to a date
     *
     * @param      string  $value  The value
     */
    public function setUpdatedAt($value)
    {
        $this->_metadata['updated_at'] = $this->deriveDate($value);

        return $this;
    }

    /**
     * Determine the value of a date
     *
     * @param      mixed  $value  The value
     *
     * @return     \CheckItOnUs\Cachet\Decorators\Date
     */
    private function deriveDate($value)
    {
        if(empty($value)) {
            return null;
        }

        if(is_a($value, Carbon::class)) {
            return Date::instance($value);
        }

        return Date::parse($value);
    }

}