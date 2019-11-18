<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface ExistsRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function exists(RoleInterface $role): bool;
}
