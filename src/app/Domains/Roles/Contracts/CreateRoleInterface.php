<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface CreateRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function create(RoleInterface $role): bool;
}
