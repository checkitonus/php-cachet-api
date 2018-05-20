<?php

namespace CheckItOnUs\Cachet\Builders;

use CheckItOnUs\Cachet\Incident;
use CheckItOnUs\Cachet\Server;

class IncidentQuery extends BaseQuery
{
    /**
     * Finds a specific Incident by the ID.
     *
     * @param int $id The identifier
     *
     * @return \CheckItOnUs\Cachet\Incident
     */
    public function findById($id)
    {
        return new Incident(
            $this->getServer(),
            (array) $this->getServer()
                ->request()
                ->get(Incident::getApiRootPath().'/'.$id)
                ->data
        );
    }

    /**
     * Finds a specific Incident based on the name.
     *
     * @param string $name The name
     *
     * @return CheckItOnUs\Cachet\Incident
     */
    public function findByName($name)
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Incident::getApiRootPath());

        foreach ($pages as $page) {
            $incident = $page->first(function ($incident) use ($name) {
                return $incident->name == $name;
            });

            if ($incident !== null) {
                return new Incident(
                    $this->getServer(),
                    (array) $incident
                );
            }
        }
    }

    /**
     * Retrieves all of the Components on the server.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Incident::getApiRootPath());

        $incidents = collect();

        foreach ($pages as $page) {
            foreach ($page as $incident) {
                $incidents->push(
                    new Incident(
                        $this->getServer(),
                        (array) $incident
                    )
                );
            }
        }

        return $incidents;
    }
}
