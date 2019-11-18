<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface UniqueRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function unique(RoleInterface $role): bool;
}
