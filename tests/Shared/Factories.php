<?php

namespace Omatech\Mage\Core\Tests\Shared;

use Illuminate\Foundation\Testing\WithFaker;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;

trait Factories
{
    use WithFaker;

    public function getPermissionInstance($name = null)
    {
        $name = $name ?? $this->faker->name;

        $permission = $this->app->make(PermissionInterface::class);
        $permission->setName($name);
        $permission->setGuardName('web');

        return $permission;
    }

    public function createPermission($name = null)
    {
        $permission = $this->getPermissionInstance($name);
        $permission->save();

        return $permission;
    }

    public function getRoleInstance($name = null)
    {
        $name = $name ?? $this->faker->name;

        $role = $this->app->make(RoleInterface::class);
        $role->setName($name);
        $role->setGuardName('web');

        return $role;
    }

    public function createRole($name = null)
    {
        $role = $this->getRoleInstance($name);
        $role->save();

        return $role;
    }

    public function getUserInstance($name = null, $email = null)
    {
        $name = $name ?? $this->faker->name;
        $email = $email ?? $this->faker->unique()->safeEmail;

        $user = $this->app->make(UserInterface::class);
        $user->setName($name);
        $user->setLanguage(app()->getLocale());
        $user->setEmail($email);
        $user->setPassword('password');

        return $user;
    }

    public function createUser($name = null, $email = null)
    {
        $user = $this->getUserInstance($name, $email);
        $user->save();

        return $user;
    }

    public function getTranslationInstance($key = null, $values = [])
    {
        $key = $key ?? 'mage.' . strtolower(str_replace(' ', '', $this->faker->name));

        $translation = $this->app->make(TranslationInterface::class);

        $translation->setKey($key);
        $translation->setTranslations($values);

        return $translation;
    }

    public function createTranslation($key = null, $values = [])
    {
        $translation = $this->getTranslationInstance($key, $values);
        $translation->save();

        return $translation;
    }
}
