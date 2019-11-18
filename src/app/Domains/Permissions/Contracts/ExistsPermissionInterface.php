<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface ExistsPermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function exists(PermissionInterface $permission): bool;
}
