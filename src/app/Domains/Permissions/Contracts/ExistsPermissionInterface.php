<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface ExistsPermissionInterface
{
    public function exists(PermissionInterface $permission): bool;
}
