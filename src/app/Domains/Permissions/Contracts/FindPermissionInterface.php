<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface FindPermissionInterface
{
    public function find(int $id): ?PermissionInterface;
}
