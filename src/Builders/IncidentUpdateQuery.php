<?php

namespace CheckItOnUs\Cachet\Builders;

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\IncidentUpdate;

class IncidentUpdateQuery
{

    /**
     * Finds a specific Incident by the ID
     *
     * @param      integer  $id     The identifier
     *
     * @return     \CheckItOnUs\Cachet\Incident
     */
    public function findById($id)
    {
        return new IncidentUpdate(
            $this->getServer(),
            (array)$this->getServer()
                ->request()
                ->get(IncidentUpdate::getApiRootPath() . '/' . $id)
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
        $pages = $this->getServer()
                    ->request()
                    ->get(IncidentUpdate::getApiRootPath());

        foreach($pages as $page) {
            $component = $page->first(function($component) use($name) {
                return $component->name == $name;
            });

            if($component !== null) {
                return new IncidentUpdate(
                    $this->getServer(),
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
        $pages = $this->getServer()
                    ->request()
                    ->get(IncidentUpdate::getApiRootPath());

        $components = collect();

        foreach($pages as $page) {
            foreach($page as $component) {
                $components->push(
                    new IncidentUpdate(
                        $this->getServer(),
                        (array)$component
                    )
                );
            }
        }

        return $components;
    }
}