<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\CreatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class CreatePermission
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
        return app()->make(CreatePermissionInterface::class)->create($permission);
    }
}
