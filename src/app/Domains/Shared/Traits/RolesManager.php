<?php

namespace Omatech\Mage\Core\Domains\Shared\Traits;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\RoleModel;

trait RolesManager
{
    /**
     * @param RoleInterface $role
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function assignRole(RoleInterface $role): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->assignRole($this->getRoles(), $role);

        return $this;
    }

    /**
     * @param array $roles
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function assignRoles(array $roles): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->assignRoles($this->getRoles(), $roles);

        return $this;
    }

    /**
     * @param RoleInterface $role
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function removeRole(RoleInterface $role): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->removeRole($this->getRoles(), $role);

        return $this;
    }

    /**
     * @param array $roles
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return self
     */
    public function removeRoles(array $roles): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->removeRoles($this->getRoles(), $roles);

        return $this;
    }
}
