<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;

class Configuration implements ArrayAccess
{
    private $_values = [];

    /**
     * Initialize and hydrate the configuration object.
     *
     * @param      array  $values  The values
     */
    public function __construct($values = [])
    {
        // Ensure the data for the configuration is correct
        if(!empty($values) && is_array($value)) {
            // It is, so populate it
            $this->_values = $values;
        }
    }

    /**
     * Determines whether or not an offset exists
     *
     * @param      mixed  $offset  The offset
     *
     * @return     boolean  Whether or not the offset exists
     */
    public function offsetExists($offset)
    {
        return isset($this->_values[$offset]);
    }

    /**
     * Retrieves the value for the offset
     *
     * @param      mixed  $offset  The offset
     *
     * @return     mixed  The value associated with the offset
     */
    public function offsetGet($offset)
    {
        return isset($this->_values[$offset]) ? $this->_values[$offset] : null;
    }

    /**
     * Sets the values for the given offset
     *
     * @param      mixed  $offset  The offset
     * @param      mixed  $value   The value
     */
    public function offsetSet($offset, $value)
    {
        $this->_values[$offset] = $value;
    }

    /**
     * Removes the value for an offset.
     *
     * @param      mixed  $offset  The offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_values[$offset]);
    }

    /**
     * Sets the API key.
     *
     * @param      string  $value  The value
     *
     * @return     \CheckItOnUs\Cachet\Configuration
     */
    public function setApiKey($value)
    {
        $this['api-key'] = $value;

        return $this;
    }

    /**
     * Retrieves the API key
     *
     * @return     string  The api key.
     */
    public function getApiKey()
    {
        return $this['api-key'];
    }

    /**
     * Sets the application's base URL
     *
     * @param      string  $value  The value
     *
     * @return     \CheckItOnUs\Cachet\Configuration
     */
    public function setBaseUrl($value)
    {
        $this['base-url'] = $value;

        return $this;
    }

    /**
     * Retrieves the base URL
     *
     * @return     string  The base url.
     */
    public function getBaseUrl()
    {
        return $this['base-url'];
    }
}