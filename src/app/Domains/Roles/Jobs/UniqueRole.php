<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\UniqueRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class UniqueRole
{
    /**
     * @param Role $role
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool
     */
    public function make(Role $role): bool
    {
        return app()->make(UniqueRoleInterface::class)->unique($role);
    }
}
