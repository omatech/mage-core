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
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->find = app()->make(FindRole::class);
    }

    /**
     * @param int $id
     *
     * @throws RoleDoesNotExistsException
     *
     * @return Role
     */
    public function make(int $id): Role
    {
        $role = $this->find->make($id);

        if (null === $role) {
            throw new RoleDoesNotExistsException();
        }

        return $role;
    }
}
