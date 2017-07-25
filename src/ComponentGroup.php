<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Component;
use CheckItOnUs\Cachet\BaseApiComponent;
use CheckItOnUs\Cachet\Traits\HasMetadata;
use CheckItOnUs\Cachet\Builders\ComponentGroupQuery;

class ComponentGroup extends BaseApiComponent
{
    use HasMetadata;

    /**
     * Hydrates a new instance of a Component
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        if(!empty($metadata['enabled_components'])) {
            $components = collect($metadata['enabled_components'])
                            ->map(function($component) use($server) {
                                return new Component($server, $component);
                            });
            unset($metadata['enabled_components']);
        }

        parent::__construct($server, $metadata);
    }

    /**
     * Dictates the server that the Component relates to.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     */
    public static function on(Server $server)
    {
        return (new ComponentGroupQuery())
            ->onServer($server);
    }

    /**
     * Gets the base path for the API
     *
     * @return     string  The api root path.
     */
    public static function getApiRootPath()
    {
        return '/v1/components/groups/';
    }
}