<?php

namespace Omatech\Mage\Core\Domains\Roles\Features;

use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleDoesNotExistsException;
use Omatech\Mage\Core\Domains\Roles\Jobs\FindRole;
use Omatech\Mage\Core\Domains\Roles\Role;

class FindOrFailRole
{
    private $find;

    /**
     * FindOrFailRole constructor.
     */
    public function __construct()
    {
        $this->find = new FindRole();
    }

    /**
     * @param int $id
     * @return Role|null
     * @throws RoleDoesNotExistsException
     */
    public function make(int $id)
    {
        $role = $this->find->make($id);

        if (null === $role) {
            throw new RoleDoesNotExistsException();
        }

        return $role;
    }
}
