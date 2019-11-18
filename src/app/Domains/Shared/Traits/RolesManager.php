<?php

namespace Omatech\Mage\Core\Domains\Shared\Traits;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\RoleModel;

trait RolesManager
{
    private $roles = [];

    abstract public function getRoles();

    /**
     * @param RoleInterface $role
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException
     */
    public function assignRole(RoleInterface $role)
    {
        $this->roles = (new RoleModel())
            ->assignRole($this->getRoles(), $role);

        return $this;
    }

    /**
     * @param array $roles
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException
     */
    public function assignRoles(array $roles)
    {
        $this->roles = (new RoleModel())
            ->assignRoles($this->getRoles(), $roles);

        return $this;
    }

    /**
     * @param RoleInterface $role
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException
     */
    public function removeRole(RoleInterface $role)
    {
        $this->roles = (new RoleModel())
            ->removeRole($this->getRoles(), $role);

        return $this;
    }

    /**
     * @param array $roles
     * @return $this
     * @throws \Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException
     */
    public function removeRoles(array $roles)
    {
        $this->roles = (new RoleModel())
            ->removeRoles($this->getRoles(), $roles);

        return $this;
    }
}
