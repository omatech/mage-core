<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\DeletePermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\ExistsPermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\AttachedPermission;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsAttachedException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;

class ExistsAndDeletePermission
{
    private $exists;
    private $attached;
    private $delete;

    /**
     * ExistsAndDeletePermission constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsPermission::class);
        $this->attached = app()->make(AttachedPermission::class);
        $this->delete = app()->make(DeletePermission::class);
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

        if ($exists === false) {
            throw new PermissionDoesNotExistsException;
        }

        $attached = $this->attached->make($permission);

        if ($attached === true) {
            throw new PermissionIsAttachedException;
        }

        return $this->delete->make($permission);
    }
}
