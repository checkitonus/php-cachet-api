<?php

namespace CheckItOnUs\Cachet\Traits;

use CheckItOnUs\Cachet\Helpers\Slug;
use CheckItOnUs\Cachet\Helpers\Text;

trait HasMetadata
{
    /**
     * The metadata about the specific component.
     *
     * @var array
     */
    protected $_metadata = [];

    /**
     * Determines whether or not an offset exists.
     *
     * @param mixed $offset The offset
     *
     * @return bool Whether or not the offset exists
     */
    public function offsetExists($offset)
    {
        return isset($this->_metadata[$offset]);
    }

    /**
     * Retrieves the value for the offset.
     *
     * @param mixed $offset The offset
     *
     * @return mixed The value associated with the offset
     */
    public function offsetGet($offset)
    {
        $method = 'get'.Text::toCamelCase($offset);

        return $this->$method();
    }

    /**
     * Sets the values for the given offset.
     *
     * @param mixed $offset The offset
     * @param mixed $value  The value
     */
    public function offsetSet($offset, $value)
    {
        $method = 'set'.Text::toCamelCase($offset);
        $this->$method($value);
    }

    /**
     * Removes the value for an offset.
     *
     * @param mixed $offset The offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_metadata[$offset]);
    }

    public function __call($name, $parameters)
    {
        // Does the method we are calling exist?
        if (method_exists($this, $name)) {
            // It does, so just call it
            return call_user_func_array([$this, $name], $parameters);
        }

        // It doesn't, so check if it's a getter/setter
        if ($matches = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY)) {
            $verb = array_shift($matches);
            $key = Slug::generate($matches);

            if ($verb == 'get') {
                return isset($this->_metadata[$key]) ? $this->_metadata[$key] : null;
            } elseif ($verb == 'set') {
                $this->_metadata[$key] = $parameters[0];

                return $this;
            }
        }
    }

    /**
     * Used internally in order to set all of the component's metadata.
     *
     * @param array $metadata The metadata
     *
     * @return \CheckItOnUs\Cachet\Component
     */
    private function setMetadata(array $metadata)
    {
        foreach ($metadata as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }

    /**
     * Used internally in order to get all of the metadaa about the component.
     *
     * @return array The metadata.
     */
    private function getMetadata()
    {
        return $this->_metadata;
    }
}
