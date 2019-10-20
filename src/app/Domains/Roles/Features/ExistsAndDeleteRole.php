<?php

namespace Omatech\Mage\Core\Domains\Roles\Features;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Roles\Jobs\DeleteRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\ExistsRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\AttachedRole;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsAttachedException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleDoesNotExistsException;

class ExistsAndDeleteRole
{
    private $exists;
    private $attached;
    private $delete;

    /**
     * ExistsAndDeleteRole constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsRole::class);
        $this->attached = app()->make(AttachedRole::class);
        $this->delete = app()->make(DeleteRole::class);
    }

    /**
     * @param Role $role
     * @return bool
     * @throws RoleDoesNotExistsException
     * @throws RoleIsAttachedException
     */
    public function make(Role $role): bool
    {
        $exists = $this->exists->make($role);

        if ($exists === false) {
            throw new RoleDoesNotExistsException;
        }

        $attached = $this->attached->make($role);

        if ($attached === true) {
            throw new RoleIsAttachedException;
        }

        return $this->delete->make($role);
    }
}
