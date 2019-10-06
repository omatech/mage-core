<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Illuminate\Support\Facades\DB;
use Omatech\Mage\Core\Domains\Roles\Contracts\AttachedRoleInterface;
use Omatech\Mage\Core\Events\Roles\RoleCreated;
use Omatech\Mage\Core\Events\Roles\RoleDeleted;
use Omatech\Mage\Core\Events\Roles\RoleUpdated;
use Omatech\Mage\Core\Models\Role;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\DeleteRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UniqueRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UpdateRoleInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

class RoleRepository extends BaseRepository implements
    AllRoleInterface,
    CreateRoleInterface,
    DeleteRoleInterface,
    ExistsRoleInterface,
    UpdateRoleInterface,
    UniqueRoleInterface,
    FindRoleInterface,
    AttachedRoleInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Role::class;
    }

    /**
     * @param GetAllInterface $all
     * @return mixed
     */
    public function get(GetAllInterface $all)
    {
        return $all->get($this->query());
    }

    /**
     * @param int $id
     * @return RoleInterface|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function find(int $id): ?RoleInterface
    {
        $role = $this->query()->find($id);

        if ($role === null) {
            return null;
        }

        $permissions = array_map(function ($permission) {
            return app()->make(PermissionInterface::class)::find($permission['id']);
        }, $role->permissions->toArray());

        $role = app()->make(RoleInterface::class)::fromArray([
            'id'         => $role->id,
            'name'       => $role->name,
            'guard_name' => $role->guard_name,
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at
        ]);

        $role->assignPermissions($permissions);

        return $role;
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function create(RoleInterface $role): bool
    {
        $wasRecentlyCreated = DB::transaction(function () use ($role) {
            $created = $this->query()->create([
                'name'       => $role->getName(),
                'guard_name' => $role->getGuardName()
            ]);

            $role->setId($created->id);
            $role->setCreatedAt($created->created_at);
            $role->setUpdatedAt($created->updated_at);

            $this->syncPermissions($created, $role);

            return $created->wasRecentlyCreated;
        });

        event(new RoleCreated($role, $wasRecentlyCreated));

        return $wasRecentlyCreated;
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function exists(RoleInterface $role): bool
    {
        return $this->query()
            ->where('name', $role->getName())
            ->exists();
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function unique(RoleInterface $role): bool
    {
        return $this->query()
            ->where('name', $role->getName())
            ->where('id', '!=', $role->getId())
            ->exists();
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function update(RoleInterface $role): bool
    {
        $isUpdated = DB::transaction(function () use ($role) {
            $updated = $this->query()->find($role->getId());

            $updated->fill([
                'name'       => $role->getName(),
                'guard_name' => $role->getGuardName()
            ])->save();

            $role->setCreatedAt($updated->created_at);
            $role->setUpdatedAt($updated->updated_at);

            $this->syncPermissions($updated, $role);

            return count($updated->getChanges()) >= 1;
        });

        event(new RoleUpdated($role, $isUpdated));

        return $isUpdated;
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function delete(RoleInterface $role): bool
    {
        $isDeleted = $this->query()
            ->where('id', $role->getId())
            ->delete();

        event(new RoleDeleted($role, $isDeleted));

        return $isDeleted;
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function attached(RoleInterface $role): bool
    {
        $model = $this->query()->find($role->getId());

        return $model->users->count() > 0;
    }

    /**
     * @param Role $model
     * @param RoleInterface $role
     */
    private function syncPermissions(Role $model, RoleInterface $role): void
    {
        $model->syncPermissions($role->getPermissionsIds());
    }
}
