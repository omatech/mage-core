<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class ExistsRole
{
    /**
     * @param Role $role
     * @return bool
     */
    public function make(Role $role): bool
    {
        return resolve(ExistsRoleInterface::class)->exists($role);
    }
}
