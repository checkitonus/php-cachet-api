<?php

namespace CheckItOnUs\Cachet\Builders;

use CheckItOnUs\Cachet\Component;
use CheckItOnUs\Cachet\Server;

class ComponentQuery extends BaseQuery
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
        return new Component(
            $this->getServer(),
            (array) $this->getServer()
                ->request()
                ->get(Component::getApiRootPath().'/'.$id)
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
                    ->get(Component::getApiRootPath());

        foreach ($pages as $page) {
            if ($page === null) {
                return;
            }

            $component = $page->first(function ($component) use ($name) {
                return $component->name == $name;
            });

            if ($component !== null) {
                return new Component(
                    $this->getServer(),
                    (array) $component
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
                    ->get(Component::getApiRootPath());

        $components = collect();

        foreach ($pages as $page) {
            foreach ($page as $component) {
                $components->push(
                    new Component(
                        $this->getServer(),
                        (array) $component
                    )
                );
            }
        }

        return $components;
    }
}
