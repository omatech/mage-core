<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface UpdatePermissionInterface
{
    public function update(PermissionInterface $permission): bool;
}
