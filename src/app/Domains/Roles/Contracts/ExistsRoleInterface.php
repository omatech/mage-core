<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface ExistsRoleInterface
{
    public function exists(RoleInterface $role): bool;
}
