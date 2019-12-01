<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class AllRole extends RoleBaseRepository implements AllRoleInterface
{
    public function get()
    {
        return $this->query()
            ->paginate()
            ->toArray();
    }
}
