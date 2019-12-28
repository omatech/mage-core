<?php

namespace Omatech\Mage\Core\Domains\Roles\Features;

use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleDoesNotExistsException;

class FindOrFailRole
{
    /**
     * @param FindRoleInterface $find
     * @param array $params
     * @return mixed
     * @throws RoleDoesNotExistsException
     */
    public function make(FindRoleInterface $find, array $params)
    {
        $role = $find->find($params);

        if (null === $role) {
            throw new RoleDoesNotExistsException();
        }

        return $role;
    }
}
