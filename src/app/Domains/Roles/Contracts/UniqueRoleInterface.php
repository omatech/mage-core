<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface UniqueRoleInterface
{
    public function unique(RoleInterface $role): bool;
}
