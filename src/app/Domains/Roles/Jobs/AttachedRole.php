<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\AttachedRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class AttachedRole
{
    /**
     * @param Role $role
     * @return bool
     */
    public function make(Role $role): bool
    {
        return resolve(AttachedRoleInterface::class)->attached($role);
    }
}
