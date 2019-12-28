<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class ExistsPermission
{
    /**
     * @param Permission $permission
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        return resolve(ExistsPermissionInterface::class)->exists($permission);
    }
}
