<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface CreatePermissionInterface
{
    public function create(PermissionInterface $permission): bool;
}
