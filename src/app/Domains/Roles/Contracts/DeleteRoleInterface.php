<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface DeleteRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function delete(RoleInterface $role): bool;
}
