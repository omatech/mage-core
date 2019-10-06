<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\AttachedPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class AttachedPermission
{
    /**
     * @param Permission $permission
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Permission $permission): bool
    {
        return app()->make(AttachedPermissionInterface::class)->attached($permission);
    }
}
