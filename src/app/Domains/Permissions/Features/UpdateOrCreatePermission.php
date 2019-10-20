<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\CreatePermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\ExistsPermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\UniquePermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\UpdatePermission;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionAlreadyExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionNameExistsMustBeUniqueException;

class UpdateOrCreatePermission
{
    private $exists;
    private $create;
    private $update;
    private $unique;

    /**
     * UpdateOrCreatePermission constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsPermission::class);
        $this->create = app()->make(CreatePermission::class);
        $this->update = app()->make(UpdatePermission::class);
        $this->unique = app()->make(UniquePermission::class);
    }

    /**
     * @param Permission $permission
     * @return bool
     * @throws PermissionAlreadyExistsException
     * @throws PermissionNameExistsMustBeUniqueException
     */
    public function make(Permission $permission): bool
    {
        if ($permission->getId() !== null) {
            return $this->update($permission);
        }

        return $this->create($permission);
    }

    /**
     * @param Permission $permission
     * @return bool
     * @throws PermissionAlreadyExistsException
     */
    private function create(Permission $permission): bool
    {
        $exists = $this->exists->make($permission);

        if ($exists === true) {
            throw new PermissionAlreadyExistsException;
        }

        return $this->create->make($permission);
    }

    /**
     * @param Permission $permission
     * @return bool
     * @throws PermissionNameExistsMustBeUniqueException
     */
    private function update(Permission $permission): bool
    {
        $exists = $this->unique->make($permission);

        if ($exists === true) {
            throw new PermissionNameExistsMustBeUniqueException;
        }

        $exists = $this->exists->make($permission);

        if ($exists === false) {
            throw new PermissionDoesNotExistsException;
        }

        return $this->update->make($permission);
    }
}
