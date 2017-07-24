<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;
use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Traits\HasMetadata;
use CheckItOnUs\Cachet\Traits\HasApiRoutes;
use CheckItOnUs\Cachet\Builders\ComponentQuery;

class Component implements ArrayAccess
{
    use HasMetadata
        ,HasApiRoutes;

    const OPERATIONAL = 1;
    const PERFORMANCE_ISSUES = 2;
    const PARTIAL_OUTAGE = 3;
    const MAJOR_OUTAGE = 4;

    /**
     * Dictates the server that the Component relates to.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     */
    public static function on(Server $server)
    {
        return (new ComponentQuery())
            ->onServer($server);
    }

    /**
     * Hydrates a new instance of a Component
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->setServer($server)
            ->setStatus(self::OPERATIONAL)
            ->setMetadata($metadata);
    }

    public function getApiRootPath()
    {
        return '/v1/components';
    }
}