<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class CreateRole
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
        return app()->make(CreateRoleInterface::class)->create($role);
    }
}
