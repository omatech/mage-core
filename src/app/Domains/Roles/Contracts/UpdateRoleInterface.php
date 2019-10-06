<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface UpdateRoleInterface
{
    public function update(RoleInterface $role): bool;
}
