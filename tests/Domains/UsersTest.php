<?php

namespace Omatech\Mage\Core\Tests\Domains;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Events\Users\UserCreated;
use Omatech\Mage\Core\Events\Users\UserDeleted;
use Omatech\Mage\Core\Events\Users\UserUpdated;
use Omatech\Mage\Core\Tests\BaseTestCase;
use Omatech\Mage\Core\Models\User as UserModel;
use Omatech\Mage\Core\Repositories\Shared\PaginateToArray;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserAlreadyExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserNameExistsMustBeUniqueException;

class UsersTest extends BaseTestCase
{
    public function testPaginateToArrayUser(): void
    {
        $pagination = $this->app->make(UserInterface::class)::all(new PaginateToArray);

        $this->assertTrue(is_array($pagination) === true);
    }

    public function testFindUser(): void
    {
        $user = $this->createUser();

        $foundUser = $this->app->make(UserInterface::class)::find($user->getId());

        $this->assertTrue($foundUser instanceof UserInterface);
        $this->assertTrue($foundUser->getId() === $user->getId());
    }

    public function testFindUserWithPermissionsAndRoles(): void
    {
        $user = $this->getUserInstance();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2')
        ]);

        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2')
        ]);

        $user->save();

        $foundUser = $this->app->make(UserInterface::class)::find($user->getId());

        $this->assertTrue($foundUser instanceof UserInterface);
        $this->assertTrue($foundUser->getId() === $user->getId());
        $this->assertTrue($user == $foundUser);
    }

    public function testExceptionOnFindUser(): void
    {
        $this->expectException(UserDoesNotExistsException::class);

        $this->app->make(UserInterface::class)::find(1);
    }

    public function testCreateUser(): void
    {
        $this->expectsEvents(UserCreated::class);

        $user = $this->createUser();

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);
    }

    public function testExceptionOnCreateUser(): void
    {
        $this->expectException(UserAlreadyExistsException::class);

        $this->createUser('user', 'user@test.com');
        $this->createUser('user', 'user@test.com');
    }

    public function testCreateUserWithPermissions(): void
    {
        $user = $this->getUserInstance();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2')
        ]);
        $user->save();

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'     => $user->getName(),
            'language' => $user->getLanguage(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);

        foreach ($user->getPermissions() as $permission) {
            $this->assertDatabaseHas(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type' => UserModel::class,
                'model_id' => $user->getId()
            ]);
        }
    }

    public function testExceptionOnCreateUserWithPermissionsNotAlreadyCreated(): void
    {
        $this->expectException(PermissionIsNotSavedException::class);

        $user = $this->getUserInstance();
        $user->assignPermissions([
            $this->getPermissionInstance()
        ]);
    }

    public function testCreateUserWithRoles(): void
    {
        $user = $this->getUserInstance();
        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2')
        ]);
        $user->save();

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'     => $user->getName(),
            'language' => $user->getLanguage(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);

        foreach ($user->getRoles() as $role) {
            $this->assertDatabaseHas(config('permission.table_names')['model_has_roles'], [
                'role_id' => $role->getId(),
                'model_type' => UserModel::class,
                'model_id' => $user->getId()
            ]);
        }
    }

    public function testExceptionOnCreateUserWithRolesNotAlreadyCreated(): void
    {
        $this->expectException(RoleIsNotSavedException::class);

        $user = $this->getUserInstance();
        $user->assignRoles([
            $this->getRoleInstance()
        ]);
    }

    public function testUpdateUser(): void
    {
        $this->expectsEvents(UserUpdated::class);

        $user = $this->createUser();
        $user->setName('newName');

        $result = $user->save();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'     => $user->getName(),
            'language' => $user->getLanguage(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);
    }

    public function testExceptionOnUpdateUser(): void
    {
        $this->expectException(UserNameExistsMustBeUniqueException::class);

        $user = $this->createUser();

        $user2 = $this->createUser();
        $user2->setEmail($user->getEmail());

        $result = $user2->save();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);
    }

    public function testUpdatePermissionFromUser(): void
    {
        $user = $this->createUser();
        $user->setName('newName');

        $result = $user->save();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'     => $user->getName(),
            'language' => $user->getLanguage(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);

        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2')
        ]);

        $user->save();

        foreach ($user->getPermissions() as $permission) {
            $this->assertDatabaseHas(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type' => UserModel::class,
                'model_id' => $user->getId()
            ]);
        }
    }

    public function testRemovePermissionFromUser(): void
    {
        $user = $this->createUser();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2')
        ]);
        $user->save();

        $user2 = clone $user;

        $user->removePermissions($user2->getPermissions());
        $user->save();

        foreach ($user2->getPermissions() as $permission) {
            $this->assertDatabaseMissing(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type' => UserModel::class,
                'model_id' => $user->getId()
            ]);
        }
    }

    public function testRemoveRoleFromUser(): void
    {
        $user = $this->createUser();
        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2')
        ]);
        $user->save();

        $user2 = clone $user;

        $user->removeRoles($user2->getRoles());
        $user->save();

        foreach ($user2->getRoles() as $role) {
            $this->assertDatabaseMissing(config('permission.table_names')['model_has_roles'], [
                'role_id' => $role->getId(),
                'model_type' => UserModel::class,
                'model_id' => $user->getId()
            ]);
        }
    }

    public function testExceptionOnUpdateUserWithPermissionsNotAlreadyCreated(): void
    {
        $this->expectException(PermissionIsNotSavedException::class);

        $user = $this->createUser();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2')
        ]);
        $user->save();

        $user->removePermissions([
            $this->getPermissionInstance('permission3')
        ]);
        $user->save();
    }

    public function testExceptionOnUpdateUserWithRolesNotAlreadyCreated(): void
    {
        $this->expectException(RoleIsNotSavedException::class);

        $user = $this->createUser();
        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2')
        ]);
        $user->save();

        $user->removeRoles([
            $this->getRoleInstance('role3')
        ]);
        $user->save();
    }

    public function testDeleteUser(): void
    {
        $this->expectsEvents(UserDeleted::class);
        $user = $this->createUser();

        $this->assertTrue(is_int($user->getId()));
        $this->assertTrue($user->getId() !== null);

        $result = $user->delete();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);

        $this->assertDatabaseMissing($this->usersDBTable, [
            'name'     => $user->getName(),
            'language' => $user->getLanguage(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);
    }

    public function testExceptionOnDeleteUser(): void
    {
        $this->expectException(UserDoesNotExistsException::class);

        $user = $this->createUser();

        $user->delete();
        $user->delete();

        $this->assertDatabaseMissing($this->usersDBTable, [
            'name'     => $user->getName(),
            'language' => $user->getLanguage(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);
    }

    public function testExceptionOnFromArrayUser(): void
    {
        $this->expectException(MethodDoesNotExistsException::class);

        $this->app->make(User::class)::fromArray([
            'noMethod' => 'noValue'
        ]);
    }
}