<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;

class FindPermission extends PermissionBaseRepository implements FindPermissionInterface
{
    public function find(int $id)
    {
        $permission = $this->query()->find($id);

        if (null === $permission) {
            return;
        }

        $permission = app('mage.permissions')::fromArray([
            'id'         => $permission->id,
            'name'       => $permission->name,
            'guard_name' => $permission->guard_name,
            'created_at' => $permission->created_at,
            'updated_at' => $permission->updated_at,
        ]);

        return $permission;
    }
}
