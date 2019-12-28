<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsAttachedException;
use Omatech\Mage\Core\Domains\Permissions\Jobs\AttachedPermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\DeletePermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\ExistsPermission;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class ExistsAndDeletePermission
{
    private $exists;
    private $attached;
    private $delete;

    /**
     * ExistsAndDeletePermission constructor.
     */
    public function __construct()
    {
        $this->exists = new ExistsPermission();
        $this->attached = new AttachedPermission();
        $this->delete = new DeletePermission();
    }


    /**
     * @param Permission $permission
     * @return bool
     * @throws PermissionDoesNotExistsException
     * @throws PermissionIsAttachedException
     */
    public function make(Permission $permission): bool
    {
        $exists = $this->exists->make($permission);

        if (false === $exists) {
            throw new PermissionDoesNotExistsException();
        }

        $attached = $this->attached->make($permission);

        if (true === $attached) {
            throw new PermissionIsAttachedException();
        }

        return $this->delete->make($permission);
    }
}
