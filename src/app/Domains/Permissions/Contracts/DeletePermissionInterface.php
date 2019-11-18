<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface DeletePermissionInterface
{
    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function delete(PermissionInterface $permission): bool;
}
