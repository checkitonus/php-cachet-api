<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Server;

class Component
{
    /**
     * The server that the component is linked to.
     * 
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

    public function __construct(Server $server)
    {
        $this->_server = $server;
    }

    /**
     * Dictates the server that the Component relates to.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     */
    public static function onServer(Server $server)
    {
        return new self($server);
    }

    public function findById($id)
    {
        return $this->_server
                ->request()
                ->get('/v1/components/' . $id)
                ->data;
    }

    public function findByName($name)
    {
        $pages = $this->_server
                    ->request()
                    ->get('/v1/components/');

        foreach($pages as $page) {
            $component = $page->first(function($component) use($name) {
                return $component->name == $name;
            });

            if($component !== null) {
                return $component;
            }
        }

        return null;
    }
}