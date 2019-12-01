<?php

namespace Omatech\Mage\Core\Providers\Bindings;

use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\AttachedRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\DeleteRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UniqueRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UpdateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Repositories\Roles\AllRole;
use Omatech\Mage\Core\Repositories\Roles\AttachedRole;
use Omatech\Mage\Core\Repositories\Roles\CreateRole;
use Omatech\Mage\Core\Repositories\Roles\DeleteRole;
use Omatech\Mage\Core\Repositories\Roles\ExistsRole;
use Omatech\Mage\Core\Repositories\Roles\FindRole;
use Omatech\Mage\Core\Repositories\Roles\UniqueRole;
use Omatech\Mage\Core\Repositories\Roles\UpdateRole;

trait RolesBindingTrait
{
    private function rolesBindings()
    {
        $this->app->bind('mage.roles', function () {
            return $this->app->make(RoleInterface::class);
        });

        $this->app->bind(RoleInterface::class, Role::class);
        $this->app->bind(AllRoleInterface::class, AllRole::class);
        $this->app->bind(FindRoleInterface::class, FindRole::class);
        $this->app->bind(CreateRoleInterface::class, CreateRole::class);
        $this->app->bind(DeleteRoleInterface::class, DeleteRole::class);
        $this->app->bind(ExistsRoleInterface::class, ExistsRole::class);
        $this->app->bind(UpdateRoleInterface::class, UpdateRole::class);
        $this->app->bind(UniqueRoleInterface::class, UniqueRole::class);
        $this->app->bind(AttachedRoleInterface::class, AttachedRole::class);
    }
}
