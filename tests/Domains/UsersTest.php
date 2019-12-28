<?php

namespace Omatech\Mage\Core\Tests\Domains;

use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException;
use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserAlreadyExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserNameExistsMustBeUniqueException;
use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Events\Users\UserCreated;
use Omatech\Mage\Core\Events\Users\UserDeleted;
use Omatech\Mage\Core\Events\Users\UserUpdated;
use Omatech\Mage\Core\Models\User as UserModel;
use Omatech\Mage\Core\Repositories\Users\AllUser;
use Omatech\Mage\Core\Repositories\Users\FindUser;
use Omatech\Mage\Core\Tests\BaseTestCase;

class UsersTest extends BaseTestCase
{
    public function testPaginateToArrayUser(): void
    {
        $pagination = resolve(UserInterface::class)::all(new AllUser());

        $this->assertTrue(true === is_array($pagination));
    }

    public function testFindUser(): void
    {
        $user = $this->createUser();

        $foundUser = resolve(UserInterface::class)::find(new FindUser(), [
            'id' => $user->getId(),
        ]);

        $this->assertTrue($foundUser instanceof UserInterface);
        $this->assertTrue($foundUser->getId() === $user->getId());
    }

    public function testFindUserWithPermissionsAndRoles(): void
    {
        $user = $this->getUserInstance();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);

        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2'),
        ]);

        $user->save();

        $foundUser = resolve(UserInterface::class)::find(new FindUser(), [
            'id' => $user->getId(),
        ]);

        $this->assertTrue($foundUser instanceof UserInterface);
        $this->assertTrue($foundUser->getId() === $user->getId());
        $this->assertTrue($user == $foundUser);
    }

    public function testExceptionOnFindUser(): void
    {
        $this->expectException(UserDoesNotExistsException::class);

        resolve(UserInterface::class)::find(new FindUser(), [
            'id' => 1,
        ]);
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
            'updated_at' => $user->getUpdatedAt(),
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
            $this->createPermission('permission2'),
        ]);
        $user->save();

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);

        foreach ($user->getPermissions() as $permission) {
            $this->assertDatabaseHas(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type'    => UserModel::class,
                'model_id'      => $user->getId(),
            ]);
        }
    }

    public function testExceptionOnCreateUserWithPermissionsNotAlreadyCreated(): void
    {
        $this->expectException(PermissionIsNotSavedException::class);

        $user = $this->getUserInstance();
        $user->assignPermissions([
            $this->getPermissionInstance(),
        ]);
    }

    public function testCreateUserWithRoles(): void
    {
        $user = $this->getUserInstance();
        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2'),
        ]);
        $user->save();

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);

        foreach ($user->getRoles() as $role) {
            $this->assertDatabaseHas(config('permission.table_names')['model_has_roles'], [
                'role_id'    => $role->getId(),
                'model_type' => UserModel::class,
                'model_id'   => $user->getId(),
            ]);
        }
    }

    public function testExceptionOnCreateUserWithRolesNotAlreadyCreated(): void
    {
        $this->expectException(RoleIsNotSavedException::class);

        $user = $this->getUserInstance();
        $user->assignRoles([
            $this->getRoleInstance(),
        ]);
    }

    public function testUpdateUser(): void
    {
        $this->expectsEvents(UserUpdated::class);

        $user = $this->createUser();
        $user->setName('newName');

        $result = $user->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnUpdateUser(): void
    {
        $this->expectException(UserNameExistsMustBeUniqueException::class);

        $user = $this->createUser();

        $user2 = $this->createUser();
        $user2->setEmail($user->getEmail());

        $result = $user2->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);
    }

    public function testUpdatePermissionFromUser(): void
    {
        $user = $this->createUser();
        $user->setName('newName');

        $result = $user->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseHas($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);

        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);

        $user->save();

        foreach ($user->getPermissions() as $permission) {
            $this->assertDatabaseHas(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type'    => UserModel::class,
                'model_id'      => $user->getId(),
            ]);
        }
    }

    public function testRemovePermissionFromUser(): void
    {
        $user = $this->createUser();
        $user->assignPermission($this->createPermission('permission1'));
        $user->save();

        $user2 = clone $user;

        $user->removePermission($user2->getPermissions()[0]);
        $user->save();

        foreach ($user2->getPermissions() as $permission) {
            $this->assertDatabaseMissing(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type'    => UserModel::class,
                'model_id'      => $user->getId(),
            ]);
        }
    }

    public function testRemovePermissionsFromUser(): void
    {
        $user = $this->createUser();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);
        $user->save();

        $user2 = clone $user;

        $user->removePermissions($user2->getPermissions());
        $user->save();

        foreach ($user2->getPermissions() as $permission) {
            $this->assertDatabaseMissing(config('permission.table_names')['model_has_permissions'], [
                'permission_id' => $permission->getId(),
                'model_type'    => UserModel::class,
                'model_id'      => $user->getId(),
            ]);
        }
    }

    public function testRemoveRoleFromUser(): void
    {
        $user = $this->createUser();
        $user->assignRole($this->createRole('role1'));
        $user->save();

        $user2 = clone $user;

        $user->removeRole($user2->getRoles()[0]);
        $user->save();

        foreach ($user2->getRoles() as $role) {
            $this->assertDatabaseMissing(config('permission.table_names')['model_has_roles'], [
                'role_id'    => $role->getId(),
                'model_type' => UserModel::class,
                'model_id'   => $user->getId(),
            ]);
        }
    }

    public function testRemoveRolesFromUser(): void
    {
        $user = $this->createUser();
        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2'),
        ]);
        $user->save();

        $user2 = clone $user;

        $user->removeRoles($user2->getRoles());
        $user->save();

        foreach ($user2->getRoles() as $role) {
            $this->assertDatabaseMissing(config('permission.table_names')['model_has_roles'], [
                'role_id'    => $role->getId(),
                'model_type' => UserModel::class,
                'model_id'   => $user->getId(),
            ]);
        }
    }

    public function testExceptionOnUpdateUserWithPermissionsNotAlreadyCreated(): void
    {
        $this->expectException(PermissionIsNotSavedException::class);

        $user = $this->createUser();
        $user->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);
        $user->save();

        $user->removePermissions([
            $this->getPermissionInstance('permission3'),
        ]);
        $user->save();
    }

    public function testExceptionOnUpdateUserWithRolesNotAlreadyCreated(): void
    {
        $this->expectException(RoleIsNotSavedException::class);

        $user = $this->createUser();
        $user->assignRoles([
            $this->createRole('role1'),
            $this->createRole('role2'),
        ]);
        $user->save();

        $user->removeRoles([
            $this->getRoleInstance('role3'),
        ]);
        $user->save();
    }

    public function testDeleteUser(): void
    {
        $this->expectsEvents(UserDeleted::class);
        $user = $this->createUser();

        $this->assertTrue(is_int($user->getId()));
        $this->assertTrue(null !== $user->getId());

        $result = $user->delete();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseMissing($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnDeleteUser(): void
    {
        $this->expectException(UserDoesNotExistsException::class);

        $user = $this->createUser();

        $user->delete();
        $user->delete();

        $this->assertDatabaseMissing($this->usersDBTable, [
            'name'       => $user->getName(),
            'language'   => $user->getLanguage(),
            'email'      => $user->getEmail(),
            'password'   => $user->getPassword(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnUpdateDeletedUser()
    {
        $this->expectException(UserDoesNotExistsException::class);

        $user = $this->createUser();
        $user->delete();

        $user->setName('userName');
        $user->save();
    }

    public function testExceptionOnFromArrayUser(): void
    {
        $this->expectException(MethodDoesNotExistsException::class);

        resolve(User::class)::fromArray([
            'noMethod' => 'noValue',
        ]);
    }
}
