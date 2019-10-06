<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface AttachedRoleInterface
{
    public function attached(RoleInterface $role): bool;
}
