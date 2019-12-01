<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Repositories\PermissionBaseRepository;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AttachedPermissionInterface;

class AttachedPermission extends PermissionBaseRepository implements AttachedPermissionInterface
{
    public function attached(PermissionInterface $permission): bool
    {
        $model = $this->query()->find($permission->getId());

        return ($model->roles->count() + $model->users->count()) > 0;
    }
}
