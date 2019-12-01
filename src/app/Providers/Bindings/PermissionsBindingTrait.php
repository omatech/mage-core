<?php

namespace Omatech\Mage\Core\Providers\Bindings;

use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AttachedPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\CreatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\DeletePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UniquePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UpdatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Repositories\Permissions\AllPermission;
use Omatech\Mage\Core\Repositories\Permissions\AttachedPermission;
use Omatech\Mage\Core\Repositories\Permissions\CreatePermission;
use Omatech\Mage\Core\Repositories\Permissions\DeletePermission;
use Omatech\Mage\Core\Repositories\Permissions\ExistsPermission;
use Omatech\Mage\Core\Repositories\Permissions\FindPermission;
use Omatech\Mage\Core\Repositories\Permissions\UniquePermission;
use Omatech\Mage\Core\Repositories\Permissions\UpdatePermission;

trait PermissionsBindingTrait
{
    private function permissionBindings()
    {
        $this->app->bind('mage.permissions', function () {
            return $this->app->make(PermissionInterface::class);
        });

        $this->app->bind(PermissionInterface::class, Permission::class);
        $this->app->bind(AllPermissionInterface::class, AllPermission::class);
        $this->app->bind(FindPermissionInterface::class, FindPermission::class);
        $this->app->bind(CreatePermissionInterface::class, CreatePermission::class);
        $this->app->bind(DeletePermissionInterface::class, DeletePermission::class);
        $this->app->bind(ExistsPermissionInterface::class, ExistsPermission::class);
        $this->app->bind(UpdatePermissionInterface::class, UpdatePermission::class);
        $this->app->bind(UniquePermissionInterface::class, UniquePermission::class);
        $this->app->bind(AttachedPermissionInterface::class, AttachedPermission::class);
    }
}
