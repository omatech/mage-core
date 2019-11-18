<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface UpdatePermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function update(PermissionInterface $permission): bool;
}
