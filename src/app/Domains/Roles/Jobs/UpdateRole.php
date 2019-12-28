<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\UpdateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class UpdateRole
{
    /**
     * @param Role $role
     * @return bool
     */
    public function make(Role $role): bool
    {
        return resolve(UpdateRoleInterface::class)->update($role);
    }
}
