<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface AttachedPermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function attached(PermissionInterface $permission): bool;
}
