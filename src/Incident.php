<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\BaseApiComponent;
use CheckItOnUs\Cachet\Decorators\Template;
use CheckItOnUs\Cachet\Builders\IncidentQuery;

class Incident extends BaseApiComponent
{

    const SCHEDULED = 0;
    const INVESTIGATING = 1;
    const IDENTIFIED = 1;
    const WATCHING = 3;
    const FIXED = 4;

    /**
     * Dictates the server that the Component relates to.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     */
    public static function on(Server $server)
    {
        return (new IncidentQuery())
            ->onServer($server);
    }

    /**
     * Hydrates a new instance of a Component
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->_metadata['template'] = new Template();
        $this->setStatus(self::INVESTIGATING)
            ->setNotify(true)
            ->setVisible(true)
            ->setName('Incident')
            ->setMessage('No message');

        parent::__construct($server, $metadata);
    }

    /**
     * Gets the base path for the API
     *
     * @return     string  The api root path.
     */
    public static function getApiRootPath()
    {
        return '/v1/incidents';
    }

    /**
     * Sets the template's name
     *
     * @param      \CheckItOnUs\Cachet\Incident  $name  The template's name
     */
    public function setTemplate($name)
    {
        $this->_metadata['template']['name'] = $name;
        return $this;
    }

    /**
     * Sets the template variables.
     *
     * @param      array  $variables  The variables
     * @return      \CheckItOnUs\Cachet\Incident
     */
    public function setVars($variables)
    {
        $this->_metadata['template']['variables'] = $variables;
        return $this;
    }

    /**
     * Adds a variable to the template
     *
     * @param      string  $key    The key
     * @param      mixed  $value  The value
     *
     * @return     \CheckItOnUs\Cachet\Incident
     */
    public function addVariable($key, $value)
    {
        $this->_metadata['template']['variables'][$key] = $value;
        return $this;
    }
}