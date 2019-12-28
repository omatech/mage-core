<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\DeletePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class DeletePermission
{
    /**
     * @param Permission $permission
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        return resolve(DeletePermissionInterface::class)->delete($permission);
    }
}
