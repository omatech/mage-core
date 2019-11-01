<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\UpdatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class UpdatePermission
{
    /**
     * @param Permission $permission
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        return app()->make(UpdatePermissionInterface::class)->update($permission);
    }
}
