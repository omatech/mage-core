<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class ExistsRole
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
        return app()->make(ExistsRoleInterface::class)->exists($role);
    }
}
