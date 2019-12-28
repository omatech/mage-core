<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\CreatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Events\Permissions\PermissionCreated;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;

class CreatePermission extends PermissionBaseRepository implements CreatePermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function create(PermissionInterface $permission): bool
    {
        $created = $this->query()->create([
            'name'       => $permission->getName(),
            'guard_name' => $permission->getGuardName(),
        ]);

        $permission->setId($created->id);
        $permission->setCreatedAt($created->created_at);
        $permission->setUpdatedAt($created->updated_at);

        event(new PermissionCreated($permission, $created->wasRecentlyCreated));

        return $created->wasRecentlyCreated;
    }
}
