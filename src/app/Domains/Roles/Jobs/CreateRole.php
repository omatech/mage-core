<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class CreateRole
{
    /**
     * @param Role $role
     * @return bool
     */
    public function make(Role $role): bool
    {
        return resolve(CreateRoleInterface::class)->create($role);
    }
}
