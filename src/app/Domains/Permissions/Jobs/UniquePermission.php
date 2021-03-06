<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\UniquePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class UniquePermission
{
    /**
     * @param Permission $permission
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        return resolve(UniquePermissionInterface::class)->unique($permission);
    }
}
