<?php

namespace CheckItOnUs\Cachet;

class Server
{
    /**
     * The configuration object
     *
     * @var        \CheckItOnUs\Cachet\Configuration
     */
    private $_configuration;

    /**
     * Initializes the Cachet component
     *
     * @param      $configuration  The configuration
     */
    public function __construct($configuration = null)
    {
        if(is_a($configuration, Configuration::class)) {
            $this->_configuration = $configuration;    
        }
        else if(!empty($configuration) && is_array($configuration)) {
            $this->_configuration = new Configuration($configuration);
        }
    }

    /**
     * Sets the configuration.
     *
     * @param      Configuration  $value  The value
     *
     * @return     \CheckItOnUs\Cachet\Cachet
     */
    public function setConfiguration(Configuration $value)
    {
        $this->_configuration = $value;

        return $this;
    }

    /**
     * Retrieves the configuration object
     *
     * @return     \CheckItOnUs\Cachet\Configuration  The configuration.
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }
}