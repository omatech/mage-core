<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface DeletePermissionInterface
{
    public function delete(PermissionInterface $permission): bool;
}
