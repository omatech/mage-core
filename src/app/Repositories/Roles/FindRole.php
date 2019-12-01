<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class FindRole extends RoleBaseRepository implements FindRoleInterface
{
    public function find(int $id)
    {
        $role = $this->query()->find($id);

        if (null === $role) {
            return null;
        }

        $permissions = array_map(static function ($permission) {
            return app('mage.permissions')::find($permission['id']);
        }, $role->permissions->toArray());

        $role = app('mage.roles')::fromArray([
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
