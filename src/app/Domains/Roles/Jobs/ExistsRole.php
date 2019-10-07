<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;

class ExistsRole
{
    /**
     * @param Role $role
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Role $role): bool
    {
        return app()->make(ExistsRoleInterface::class)->exists($role);
    }
}