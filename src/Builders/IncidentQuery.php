<?php

namespace CheckItOnUs\Cachet\Builders;

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Incident;

class IncidentQuery
{
    /**
     * The server that the component is linked to.
     * 
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

    /**
     * Sets the server which we will be looking at
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     */
    public function onServer(Server $server)
    {
        $this->_server = $server;

        return $this;
    }

    /**
     * Finds a specific Incident by the ID
     *
     * @param      integer  $id     The identifier
     *
     * @return     \CheckItOnUs\Cachet\Incident
     */
    public function findById($id)
    {
        return new Incident(
            $this->_server,
            (array)$this->_server
                ->request()
                ->get(Incident::getApiRootPath() . '/' . $id)
                ->data
        );
    }

    /**
     * Finds a specific Incident based on the name
     *
     * @param      string     $name   The name
     *
     * @return     CheckItOnUs\Cachet\Incident
     */
    public function findByName($name)
    {
        $pages = $this->_server
                    ->request()
                    ->get(Incident::getApiRootPath());

        foreach($pages as $page) {
            $component = $page->first(function($component) use($name) {
                return $component->name == $name;
            });

            if($component !== null) {
                return new Incident(
                    $this->_server,
                    (array)$component
                );
            }
        }

        return null;
    }

    /**
     * Retrieves all of the Components on the server
     *
     * @return     \Illuminate\Support\Collection
     */
    public function all()
    {
        $pages = $this->_server
                    ->request()
                    ->get(Incident::getApiRootPath());

        $components = collect();

        foreach($pages as $page) {
            foreach($page as $component) {
                $components->push(
                    new Incident(
                        $this->_server,
                        (array)$component
                    )
                );
            }
        }

        return $components;
    }
}