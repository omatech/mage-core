<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Repositories\PermissionBaseRepository;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;

class ExistsPermission extends PermissionBaseRepository implements ExistsPermissionInterface
{
    public function exists(PermissionInterface $permission): bool
    {
        return $this->query()
            ->where('name', $permission->getName())
            ->orWhere('id', $permission->getId())
            ->exists();
    }
}
