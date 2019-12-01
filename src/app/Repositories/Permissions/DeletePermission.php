<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\DeletePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Events\Permissions\PermissionDeleted;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;

class DeletePermission extends PermissionBaseRepository implements DeletePermissionInterface
{
    public function delete(PermissionInterface $permission): bool
    {
        $isDeleted = $this->query()
            ->where('id', $permission->getId())
            ->delete();

        event(new PermissionDeleted($permission, $isDeleted > 0));

        return $isDeleted > 0;
    }
}
