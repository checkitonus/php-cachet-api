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
            $incidentUpdate = $page->first(function($incidentUpdate) use($name) {
                return $incidentUpdate->name == $name;
            });

            if($incidentUpdate !== null) {
                return new IncidentUpdate(
                    $this->getServer(),
                    (array)$incidentUpdate
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

        $incidentUpdates = collect();

        foreach($pages as $page) {
            foreach($page as $incidentUpdate) {
                $incidentUpdates->push(
                    new IncidentUpdate(
                        $this->getServer(),
                        (array)$incidentUpdate
                    )
                );
            }
        }

        return $incidentUpdates;
    }
}