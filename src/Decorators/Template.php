<?php

namespace CheckItOnUs\Cachet\Decorators;

use ArrayAccess;
use CheckItOnUs\Cachet\ApiRequest;
use CheckItOnUs\Cachet\Helpers\Slug;
use CheckItOnUs\Cachet\Traits\HasMetadata;
use CheckItOnUs\Cachet\Decorators\Template\VariableCollection;

class Template implements ArrayAccess, ApiRequest
{
    use HasMetadata;

    /**
     * Converts the object to a format which can be used when making an API 
     * request.
     * 
     * @return mixed
     */
    public function toApi()
    {
        return [
            'template' => Slug::generate($this['name']),
            'vars' => $this['variables']->all(),
        ];
    }

    /**
     * Retrieves the "vars" attribute
     *
     * @return     \CheckItOnUs\Cachet\Decorators\Template\VariableCollection  The variables.
     */
    public function getVars()
    {
        return $this['variables'];
    }

    public function getVariables()
    {
        if(!isset($this->_metadata['variables'])) {
            $this['variables'] = [];
        }

        return $this->_metadata['variables'];
    }

    public function setVariables(array $value)
    {
        $this->_metadata['variables'] = new VariableCollection($value);
        return $this;
    }

    public function addVariable($key, $value)
    {
        $this['variables'][$key] = $value;
        return $this;
    }
}