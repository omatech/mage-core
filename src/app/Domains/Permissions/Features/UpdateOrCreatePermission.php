<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionAlreadyExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionNameExistsMustBeUniqueException;
use Omatech\Mage\Core\Domains\Permissions\Jobs\CreatePermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\ExistsPermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\UniquePermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\UpdatePermission;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class UpdateOrCreatePermission
{
    private $exists;
    private $create;
    private $update;
    private $unique;

    /**
     * UpdateOrCreatePermission constructor.
     */
    public function __construct()
    {
        $this->exists = new ExistsPermission();
        $this->create = new CreatePermission();
        $this->update = new UpdatePermission();
        $this->unique = new UniquePermission();
    }

    /**
     * @param Permission $permission
     *
     * @throws PermissionAlreadyExistsException
     * @throws PermissionNameExistsMustBeUniqueException
     * @throws PermissionDoesNotExistsException
     *
     * @return bool
     */
    public function make(Permission $permission): bool
    {
        if (null !== $permission->getId()) {
            return $this->update($permission);
        }

        return $this->create($permission);
    }

    /**
     * @param Permission $permission
     *
     * @throws PermissionAlreadyExistsException
     *
     * @return bool
     */
    private function create(Permission $permission): bool
    {
        $exists = $this->exists->make($permission);

        if (true === $exists) {
            throw new PermissionAlreadyExistsException();
        }

        return $this->create->make($permission);
    }

    /**
     * @param Permission $permission
     *
     * @throws PermissionNameExistsMustBeUniqueException
     * @throws PermissionDoesNotExistsException
     *
     * @return bool
     */
    private function update(Permission $permission): bool
    {
        $exists = $this->unique->make($permission);

        if (true === $exists) {
            throw new PermissionNameExistsMustBeUniqueException();
        }

        $exists = $this->exists->make($permission);

        if (false === $exists) {
            throw new PermissionDoesNotExistsException();
        }

        return $this->update->make($permission);
    }
}
