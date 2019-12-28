<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\DeleteRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class DeleteRole
{
    /**
     * @param Role $role
     * @return bool
     */
    public function make(Role $role): bool
    {
        return resolve(DeleteRoleInterface::class)->delete($role);
    }
}
