<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\UpdatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class UpdatePermission
{
    /**
     * @param Permission $permission
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        return resolve(UpdatePermissionInterface::class)->update($permission);
    }
}
