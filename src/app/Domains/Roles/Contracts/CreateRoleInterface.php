<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface CreateRoleInterface
{
    public function create(RoleInterface $role): bool;
}
