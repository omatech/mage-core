<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface AttachedPermissionInterface
{
    public function attached(PermissionInterface $permission): bool;
}
