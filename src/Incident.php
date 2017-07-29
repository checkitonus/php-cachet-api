<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\BaseApiComponent;
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
        $this->setStatus(self::INVESTIGATING)
            ->setNotify(true);

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
}