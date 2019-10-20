<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;

class CreateRole
{
    /**
     * @param Role $role
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Role $role): bool
    {
        return app()->make(CreateRoleInterface::class)->create($role);
    }
}
