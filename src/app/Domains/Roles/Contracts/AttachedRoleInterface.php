<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface AttachedRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function attached(RoleInterface $role): bool;
}
