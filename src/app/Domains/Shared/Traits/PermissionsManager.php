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
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function assignPermission(PermissionInterface $permission): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->assignPermission($this->getPermissions(), $permission);

        return $this;
    }

    /**
     * @param array $permissions
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function assignPermissions(array $permissions): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->assignPermissions($this->getPermissions(), $permissions);

        return $this;
    }

    /**
     * @param PermissionInterface $permission
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function removePermission(PermissionInterface $permission): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->removePermission($this->getPermissions(), $permission);

        return $this;
    }

    /**
     * @param array $permissions
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function removePermissions(array $permissions): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->removePermissions($this->getPermissions(), $permissions);

        return $this;
    }
}
