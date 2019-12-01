<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UniqueRoleInterface;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class UniqueRole extends RoleBaseRepository implements UniqueRoleInterface
{
    public function unique(RoleInterface $role): bool
    {
        return $this->query()
            ->where('name', $role->getName())
            ->where('id', '!=', $role->getId())
            ->exists();
    }
}
