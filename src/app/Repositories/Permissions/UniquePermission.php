<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UniquePermissionInterface;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;

class UniquePermission extends PermissionBaseRepository implements UniquePermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function unique(PermissionInterface $permission): bool
    {
        return $this->query()
            ->where('name', $permission->getName())
            ->where('id', '!=', $permission->getId())
            ->exists();
    }
}
