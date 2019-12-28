<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Repositories\Permissions\FindPermission;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class FindRole extends RoleBaseRepository implements FindRoleInterface
{
    /**
     * @param array $params
     */
    public function find(array $params)
    {
        $role = $this->query()->find($params['id']);

        if (null === $role) {
            return null;
        }

        $permissions = array_map(static function ($permission) {
            return resolve('mage.permissions')::find(new FindPermission(), [
                'id' => $permission['id'],
            ]);
        }, $role->permissions->toArray());

        $role = resolve('mage.roles')::fromArray([
            'id'         => $role->id,
            'name'       => $role->name,
            'guard_name' => $role->guard_name,
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at,
        ]);

        $role->assignPermissions($permissions);

        return $role;
    }
}
