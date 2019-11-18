<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface CreatePermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function create(PermissionInterface $permission): bool;
}
