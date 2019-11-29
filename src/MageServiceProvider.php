<?php

namespace Omatech\Mage\Core;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
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
use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\CreateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Repositories\PermissionRepository;
use Omatech\Mage\Core\Repositories\RoleRepository;
use Omatech\Mage\Core\Repositories\TranslationRepository;
use Omatech\Mage\Core\Repositories\Users\AllUser;
use Omatech\Mage\Core\Repositories\Users\CreateUser;
use Omatech\Mage\Core\Repositories\Users\DeleteUser;
use Omatech\Mage\Core\Repositories\Users\ExistsUser;
use Omatech\Mage\Core\Repositories\Users\FindUser;
use Omatech\Mage\Core\Repositories\Users\UniqueUser;
use Omatech\Mage\Core\Repositories\Users\UpdateUser;

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
        $this->translationBindings();

        $this->app->bind('mage.permissions', function () {
            return $this->app->make(PermissionInterface::class);
        });

        $this->app->bind('mage.roles', function () {
            return $this->app->make(RoleInterface::class);
        });

        $this->app->bind('mage.users', function () {
            return $this->app->make(UserInterface::class);
        });

        $this->app->bind('mage.translations', function () {
            return $this->app->make(TranslationInterface::class);
        });

        $this->publishes($this->migrations(), 'mage-migrations');
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
        $this->app->bind(AllUserInterface::class, AllUser::class);
        $this->app->bind(FindUserInterface::class, FindUser::class);
        $this->app->bind(CreateUserInterface::class, CreateUser::class);
        $this->app->bind(DeleteUserInterface::class, DeleteUser::class);
        $this->app->bind(ExistsUserInterface::class, ExistsUser::class);
        $this->app->bind(UpdateUserInterface::class, UpdateUser::class);
        $this->app->bind(UniqueUserInterface::class, UniqueUser::class);
    }

    private function translationBindings()
    {
        $this->app->bind(TranslationInterface::class, Translation::class);
        $this->app->bind(AllTranslationInterface::class, TranslationRepository::class);
        $this->app->bind(FindTranslationInterface::class, TranslationRepository::class);
        $this->app->bind(CreateTranslationInterface::class, TranslationRepository::class);
        $this->app->bind(DeleteTranslationInterface::class, TranslationRepository::class);
        $this->app->bind(ExistsTranslationInterface::class, TranslationRepository::class);
        $this->app->bind(UpdateTranslationInterface::class, TranslationRepository::class);
        $this->app->bind(UniqueTranslationInterface::class, TranslationRepository::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'mage'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/permission.php',
            'permission'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.providers.php',
            'auth.providers'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.guards.php',
            'auth.guards'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/translation-loader.php',
            'translation-loader'
        );
    }

    public function migrations()
    {
        $migrations = [];

        $filesystem = new Filesystem();
        $source = __DIR__.'/database/migrations/';
        $destination = $this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR;

        foreach ($filesystem->files($source) as $index => $file) {
            $sourceFileName = $file->getFilename();
            $migrationName = substr($sourceFileName, 18, strlen($sourceFileName));

            $fileExists = 0 != count($filesystem->glob($destination.'*'.$migrationName));

            if (! $fileExists) {
                $destinationFileName = date('Y_m_d').'_'.str_pad($index, 6, '0').'_'.$migrationName;
                $migrations[$source.$sourceFileName] = $destination.$destinationFileName;
            }
        }

        return $migrations;
    }
}
