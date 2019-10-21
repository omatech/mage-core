<?php

namespace Omatech\Mage\Core\Domains\Roles\Features;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Roles\Jobs\CreateRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\ExistsRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\UniqueRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\UpdateRole;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleAlreadyExistsException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleDoesNotExistsException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleNameExistsMustBeUniqueException;

class UpdateOrCreateRole
{
    private $exists;
    private $create;
    private $update;
    private $unique;

    /**
     * UpdateOrCreateRole constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsRole::class);
        $this->create = app()->make(CreateRole::class);
        $this->update = app()->make(UpdateRole::class);
        $this->unique = app()->make(UniqueRole::class);
    }

    /**
     * @param Role $role
     * @return bool
     * @throws RoleAlreadyExistsException
     * @throws RoleNameExistsMustBeUniqueException
     */
    public function make(Role $role): bool
    {
        if ($role->getId() !== null) {
            return $this->update($role);
        }

        return $this->create($role);
    }

    /**
     * @param Role $role
     * @return bool
     * @throws RoleAlreadyExistsException
     */
    private function create(Role $role): bool
    {
        $exists = $this->exists->make($role);

        if ($exists === true) {
            throw new RoleAlreadyExistsException;
        }

        return $this->create->make($role);
    }

    /**
     * @param Role $role
     * @return bool
     * @throws RoleNameExistsMustBeUniqueException
     * @throws RoleDoesNotExistsException
     */
    private function update(Role $role): bool
    {
        $exists = $this->unique->make($role);

        if ($exists === true) {
            throw new RoleNameExistsMustBeUniqueException;
        }

        $exists = $this->exists->make($role);

        if ($exists === false) {
            throw new RoleDoesNotExistsException;
        }

        return $this->update->make($role);
    }
}
