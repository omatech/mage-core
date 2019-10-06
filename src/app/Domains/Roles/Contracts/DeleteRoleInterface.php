<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface DeleteRoleInterface
{
    public function delete(RoleInterface $role): bool;
}
