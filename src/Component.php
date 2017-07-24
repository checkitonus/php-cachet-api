<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;
use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\BaseApiComponent;
use CheckItOnUs\Cachet\Traits\HasMetadata;
use CheckItOnUs\Cachet\Traits\HasApiRoutes;
use CheckItOnUs\Cachet\Builders\ComponentQuery;

class Component extends BaseApiComponent implements ArrayAccess
{
    use HasMetadata;

    const OPERATIONAL = 1;
    const PERFORMANCE_ISSUES = 2;
    const PARTIAL_OUTAGE = 3;
    const MAJOR_OUTAGE = 4;

    /**
     * Hydrates a new instance of a Component
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->setStatus(self::OPERATIONAL);

        parent::__construct($server, $metadata);
    }

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

    public static function getApiRootPath()
    {
        return '/v1/components';
    }
}