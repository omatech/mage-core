<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Events\Permissions\PermissionUpdated;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UpdatePermissionInterface;

class UpdatePermission extends PermissionBaseRepository implements UpdatePermissionInterface
{
    public function update(PermissionInterface $permission): bool
    {
        $updated = $this->query()->find($permission->getId());

        $updated->fill([
            'name'       => $permission->getName(),
            'guard_name' => $permission->getGuardName(),
        ])->save();

        $permission->setCreatedAt($updated->created_at);
        $permission->setUpdatedAt($updated->updated_at);

        event(new PermissionUpdated($permission, count($updated->getChanges()) >= 1));

        return count($updated->getChanges()) >= 1;
    }
}
