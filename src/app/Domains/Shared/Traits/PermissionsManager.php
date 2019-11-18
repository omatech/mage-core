<?php

namespace Omatech\Mage\Core\Domains\Shared\Traits;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\PermissionModel;

trait PermissionsManager
{
    private $permissions = [];

    abstract public function getPermissions();

    /**
     * @param PermissionInterface $permission
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException
     */
    public function assignPermission(PermissionInterface $permission)
    {
        $this->permissions = (new PermissionModel())
            ->assignPermission($this->getPermissions(), $permission);

        return $this;
    }

    /**
     * @param array $permissions
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException
     */
    public function assignPermissions(array $permissions)
    {
        $this->permissions = (new PermissionModel())
            ->assignPermissions($this->getPermissions(), $permissions);

        return $this;
    }

    /**
     * @param PermissionInterface $permission
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException
     */
    public function removePermission(PermissionInterface $permission)
    {
        $this->permissions = (new PermissionModel())
            ->removePermission($this->getPermissions(), $permission);

        return $this;
    }

    /**
     * @param array $permissions
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException
     */
    public function removePermissions(array $permissions)
    {
        $this->permissions = (new PermissionModel())
            ->removePermissions($this->getPermissions(), $permissions);

        return $this;
    }
}
