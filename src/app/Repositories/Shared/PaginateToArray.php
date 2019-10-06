<?php

namespace Omatech\Mage\Core\Repositories\Shared;

use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;

class PaginateToArray implements GetAllInterface
{
    /**
     * @param GetAllInterface $query
     * @return mixed
     */
    public function get($query)
    {
        return $query->paginate()->toArray();
    }
}
