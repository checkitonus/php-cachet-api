<?php

namespace CheckItOnUs\Cachet\Builders;

use CheckItOnUs\Cachet\Component;
use CheckItOnUs\Cachet\ComponentGroup;

class ComponentGroupQuery extends BaseQuery
{
    /**
     * Finds a specific Component by the ID.
     *
     * @param int $id The identifier
     *
     * @return \CheckItOnUs\Cachet\Component
     */
    public function findById($id)
    {
        return new ComponentGroup(
            $this->getServer(),
            (array) $this->getServer()
                ->request()
                ->get(ComponentGroup::getApiRootPath().'/'.$id)
                ->data
        );
    }

    /**
     * Finds a specific Component based on the name.
     *
     * @param string $name The name
     *
     * @return CheckItOnUs\Cachet\Component
     */
    public function findByName($name)
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(ComponentGroup::getApiRootPath());

        foreach ($pages as $page) {
            $componentGroup = $page->first(function ($componentGroup) use ($name) {
                return $componentGroup->name == $name;
            });

            if ($componentGroup !== null) {
                return new ComponentGroup(
                    $this->getServer(),
                    (array) $componentGroup
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
                    ->get(ComponentGroup::getApiRootPath());

        $componentGroups = collect();

        foreach ($pages as $page) {
            foreach ($page as $componentGroup) {
                $componentGroups->push(
                    new ComponentGroup(
                        $this->getServer(),
                        (array) $componentGroup
                    )
                );
            }
        }

        return $componentGroups;
    }
}
