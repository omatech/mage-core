<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface UniquePermissionInterface
{
    public function unique(PermissionInterface $permission): bool;
}
