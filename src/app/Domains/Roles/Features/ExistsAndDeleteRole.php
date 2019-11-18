<?php

namespace Omatech\Mage\Core\Domains\Roles\Features;

use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleDoesNotExistsException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsAttachedException;
use Omatech\Mage\Core\Domains\Roles\Jobs\AttachedRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\DeleteRole;
use Omatech\Mage\Core\Domains\Roles\Jobs\ExistsRole;
use Omatech\Mage\Core\Domains\Roles\Role;

class ExistsAndDeleteRole
{
    private $exists;
    private $attached;
    private $delete;

    /**
     * ExistsAndDeleteRole constructor.
     */
    public function __construct()
    {
        $this->exists = new ExistsRole();
        $this->attached = new AttachedRole();
        $this->delete = new DeleteRole();
    }

    /**
     * @param Role $role
     *
     * @throws RoleDoesNotExistsException
     * @throws RoleIsAttachedException
     *
     * @return bool
     */
    public function make(Role $role): bool
    {
        $exists = $this->exists->make($role);

        if (false === $exists) {
            throw new RoleDoesNotExistsException();
        }

        $attached = $this->attached->make($role);

        if (true === $attached) {
            throw new RoleIsAttachedException();
        }

        return $this->delete->make($role);
    }
}
