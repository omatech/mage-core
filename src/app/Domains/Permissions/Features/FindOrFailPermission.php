<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;

class FindOrFailPermission
{
    /**
     * @param FindPermissionInterface $find
     * @param array $params
     * @return mixed
     * @throws PermissionDoesNotExistsException
     */
    public function make(FindPermissionInterface $find, array $params)
    {
        $permission = $find->find($params);

        if (null === $permission) {
            throw new PermissionDoesNotExistsException();
        }

        return $permission;
    }
}
