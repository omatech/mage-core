<?php

namespace Omatech\Mage\Core;

use Illuminate\Support\ServiceProvider;
use Omatech\Mage\Core\Domains\Roles\Contracts\AttachedRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Repositories\RoleRepository;
use Omatech\Mage\Core\Repositories\UserRepository;
use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Repositories\PermissionRepository;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\DeleteRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\ExistsRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UniqueRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UpdateRoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\CreatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\DeletePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\ExistsPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UniquePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\UpdatePermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AttachedPermissionInterface;

class MageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->permissionBindings();
        $this->roleBindings();
        $this->userBindings();
    }

    private function permissionBindings()
    {
        $this->app->bind(PermissionInterface::class, Permission::class);
        $this->app->bind(AllPermissionInterface::class, PermissionRepository::class);
        $this->app->bind(FindPermissionInterface::class, PermissionRepository::class);
        $this->app->bind(CreatePermissionInterface::class, PermissionRepository::class);
        $this->app->bind(DeletePermissionInterface::class, PermissionRepository::class);
        $this->app->bind(ExistsPermissionInterface::class, PermissionRepository::class);
        $this->app->bind(UpdatePermissionInterface::class, PermissionRepository::class);
        $this->app->bind(UniquePermissionInterface::class, PermissionRepository::class);
        $this->app->bind(AttachedPermissionInterface::class, PermissionRepository::class);
    }

    private function roleBindings()
    {
        $this->app->bind(RoleInterface::class, Role::class);
        $this->app->bind(AllRoleInterface::class, RoleRepository::class);
        $this->app->bind(FindRoleInterface::class, RoleRepository::class);
        $this->app->bind(CreateRoleInterface::class, RoleRepository::class);
        $this->app->bind(DeleteRoleInterface::class, RoleRepository::class);
        $this->app->bind(ExistsRoleInterface::class, RoleRepository::class);
        $this->app->bind(UpdateRoleInterface::class, RoleRepository::class);
        $this->app->bind(UniqueRoleInterface::class, RoleRepository::class);
        $this->app->bind(AttachedRoleInterface::class, RoleRepository::class);
    }

    private function userBindings()
    {
        $this->app->bind(UserInterface::class, User::class);
        $this->app->bind(AllUserInterface::class, UserRepository::class);
        $this->app->bind(FindUserInterface::class, UserRepository::class);
        $this->app->bind(CreateUserInterface::class, UserRepository::class);
        $this->app->bind(DeleteUserInterface::class, UserRepository::class);
        $this->app->bind(ExistsUserInterface::class, UserRepository::class);
        $this->app->bind(UpdateUserInterface::class, UserRepository::class);
        $this->app->bind(UniqueUserInterface::class, UserRepository::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/permission.php',
            'permission'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.providers.php',
            'auth.providers'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.guards.php',
            'auth.guards'
        );
    }
}
