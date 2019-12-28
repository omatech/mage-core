<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\CreatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class CreatePermission
{
    /**
     * @param Permission $permission
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        return resolve(CreatePermissionInterface::class)->create($permission);
    }
}
