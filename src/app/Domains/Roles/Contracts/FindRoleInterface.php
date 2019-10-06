<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface FindRoleInterface
{
    public function find(int $id): ?RoleInterface;
}
