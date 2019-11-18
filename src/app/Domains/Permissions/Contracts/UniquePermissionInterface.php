<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface UniquePermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function unique(PermissionInterface $permission): bool;
}
