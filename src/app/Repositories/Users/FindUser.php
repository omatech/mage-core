<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Repositories\Permissions\FindPermission;
use Omatech\Mage\Core\Repositories\Roles\FindRole;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class FindUser extends UserBaseRepository implements FindUserInterface
{
    /**
     * @param array $params
     * @return void
     */
    public function find(array $params)
    {
        $user = $this->query()->find($params['id']);

        if (null === $user) {
            return;
        }

        $permissions = array_map(static function ($permission) {
            return app('mage.permissions')::find(new FindPermission(), [
                'id' => $permission['id'],
            ]);
        }, $user->permissions->toArray());

        $roles = array_map(static function ($role) {
            return app('mage.roles')::find(new FindRole(), [
                'id' => $role['id'],
            ]);
        }, $user->roles->toArray());

        $user = app('mage.users')::fromArray([
            'id'                => $user->id,
            'name'              => $user->name,
            'language'          => $user->language,
            'email'             => $user->email,
            'email_verified_at' => $user->verified_at,
            'password'          => $user->password,
            'remember_token'    => $user->remember_token,
            'created_at'        => $user->created_at,
            'updated_at'        => $user->updated_at,
        ]);

        $user->assignPermissions($permissions);
        $user->assignRoles($roles);

        return $user;
    }
}
