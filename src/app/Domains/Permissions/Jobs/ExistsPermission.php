<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;

class ExistsPermission
{
    /**
     * @param Permission $permission
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Permission $permission): bool
    {
        return app()->make(ExistsPermissionInterface::class)->exists($permission);
    }
}
