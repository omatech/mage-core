<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\UpdateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class UpdateRole
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
        return app()->make(UpdateRoleInterface::class)->update($role);
    }
}
