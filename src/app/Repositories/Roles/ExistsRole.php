<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class ExistsRole extends RoleBaseRepository implements ExistsRoleInterface
{
    public function exists(RoleInterface $role): bool
    {
        return $this->query()
            ->where('name', $role->getName())
            ->orWhere('id', $role->getId())
            ->exists();
    }
}
