<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;

class ExistsPermission extends PermissionBaseRepository implements ExistsPermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function exists(PermissionInterface $permission): bool
    {
        return $this->query()
            ->where('name', $permission->getName())
            ->orWhere('id', $permission->getId())
            ->exists();
    }
}
