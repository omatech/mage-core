<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\DeleteRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class DeleteRole
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
        return app()->make(DeleteRoleInterface::class)->delete($role);
    }
}
