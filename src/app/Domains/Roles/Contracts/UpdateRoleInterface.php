<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface UpdateRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function update(RoleInterface $role): bool;
}
