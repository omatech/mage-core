<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Permissions\Contracts\DeletePermissionInterface;

class DeletePermission
{
    /**
     * @param Permission $permission
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Permission $permission): bool
    {
        return app()->make(DeletePermissionInterface::class)->delete($permission);
    }
}
