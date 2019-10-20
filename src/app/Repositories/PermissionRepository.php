<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Models\Permission;
use Omatech\Mage\Core\Events\Permissions\PermissionCreated;
use Omatech\Mage\Core\Events\Permissions\PermissionDeleted;
use Omatech\Mage\Core\Events\Permissions\PermissionUpdated;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\CreatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\DeletePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UniquePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UpdatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AttachedPermissionInterface;

class PermissionRepository extends BaseRepository implements
    AllPermissionInterface,
    CreatePermissionInterface,
    DeletePermissionInterface,
    ExistsPermissionInterface,
    FindPermissionInterface,
    AttachedPermissionInterface,
    UniquePermissionInterface,
    UpdatePermissionInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Permission::class;
    }

    public function get()
    {
        return $this->query()->paginate()->toArray();
    }

    /**
     * @param int $id
     * @return PermissionInterface|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function find(int $id): ?PermissionInterface
    {
        $permission = $this->query()->find($id);

        if ($permission === null) {
            return null;
        }

        $permission = app()->make(PermissionInterface::class)::fromArray([
            'id'         => $permission->id,
            'name'       => $permission->name,
            'guard_name' => $permission->guard_name,
            'created_at' => $permission->created_at,
            'updated_at' => $permission->updated_at,
        ]);

        return $permission;
    }

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

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function exists(PermissionInterface $permission): bool
    {
        return $this->query()
            ->where('name', $permission->getName())
            ->orWhere('id', $permission->getId())
            ->exists();
    }

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function unique(PermissionInterface $permission): bool
    {
        return $this->query()
            ->where('name', $permission->getName())
            ->where('id', '!=', $permission->getId())
            ->exists();
    }

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
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

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function delete(PermissionInterface $permission): bool
    {
        $isDeleted = $this->query()
            ->where('id', $permission->getId())
            ->delete();

        $isDeleted = $isDeleted > 0;

        event(new PermissionDeleted($permission, $isDeleted));

        return $isDeleted;
    }

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function attached(PermissionInterface $permission): bool
    {
        $model = $this->query()->find($permission->getId());

        return ($model->roles->count() + $model->users->count()) > 0;
    }
}
