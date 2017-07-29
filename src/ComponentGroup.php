<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Component;
use CheckItOnUs\Cachet\BaseApiComponent;
use CheckItOnUs\Cachet\Builders\ComponentGroupQuery;

class ComponentGroup extends BaseApiComponent
{
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
        return '/v1/components/groups';
    }
    
    /**
     * Retrieves a collection of Components
     *
     * @return     Illuminate\Support\Collection  The components.
     */
    public function getComponents()
    {
        return $this['enabled_components'];
    }

    /**
     * Sets the list of enabled components.
     *
     * @param      array   $value  The value
     *
     * @return     CheckItOnUs\Cachet\ComponentGroup
     */
    public function setEnabledComponents(array $value)
    {
        $this->_metadata['enabled_components'] = collect($value)
                                ->map(function($component) {
                                    return new Component($this->getServer(), (array)$component);
                                });
        return $this;
    }
}