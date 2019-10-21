<?php

namespace Omatech\Mage\Core\Tests\Domains;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Tests\BaseTestCase;
use Omatech\Mage\Core\Events\Roles\RoleCreated;
use Omatech\Mage\Core\Events\Roles\RoleDeleted;
use Omatech\Mage\Core\Events\Roles\RoleUpdated;
use Omatech\Mage\Core\Repositories\RoleRepository;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsAttachedException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleAlreadyExistsException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleDoesNotExistsException;
use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleNameExistsMustBeUniqueException;

class RolesTest extends BaseTestCase
{
    public function testPaginateToArrayRole(): void
    {
        $pagination = $this->app->make(RoleInterface::class)::all(new RoleRepository);

        $this->assertTrue(is_array($pagination) === true);
    }

    public function testFindRole(): void
    {
        $role = $this->createRole();

        $foundRole = $this->app->make(RoleInterface::class)::find($role->getId());

        $this->assertTrue($foundRole instanceof RoleInterface);
        $this->assertTrue($foundRole->getId() === $role->getId());
    }

    public function testFindRoleWithPermission(): void
    {
        $role = $this->getRoleInstance();
        $role->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);
        $role->save();

        $foundRole = $this->app->make(RoleInterface::class)::find($role->getId());

        $this->assertTrue($foundRole instanceof RoleInterface);
        $this->assertTrue($foundRole->getId() === $role->getId());
        $this->assertTrue($role == $foundRole);
    }

    public function testExceptionOnFindRole(): void
    {
        $this->expectException(RoleDoesNotExistsException::class);

        $this->app->make(RoleInterface::class)::find(1);
    }

    public function testCreateRole(): void
    {
        $this->expectsEvents(RoleCreated::class);
        $role = $this->createRole();

        $this->assertDatabaseHas(config('permission.table_names')['roles'], [
            'name'       => $role->getName(),
            'guard_name' => $role->getGuardName(),
            'created_at' => $role->getCreatedAt(),
            'updated_at' => $role->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnCreateRole(): void
    {
        $this->expectException(RoleAlreadyExistsException::class);

        $this->createRole('role');
        $this->createRole('role');
    }

    public function testCreateRoleWithPermission(): void
    {
        $role = $this->getRoleInstance();
        $role->assignPermission($this->createPermission('permission1'));
        $role->save();

        $this->assertDatabaseHas(config('permission.table_names')['roles'], [
            'name'       => $role->getName(),
            'guard_name' => $role->getGuardName(),
            'created_at' => $role->getCreatedAt(),
            'updated_at' => $role->getUpdatedAt(),
        ]);

        $permission = $role->getPermissions()[0];

        $this->assertDatabaseHas(config('permission.table_names')['role_has_permissions'], [
            'permission_id' => $permission->getId(),
            'role_id' => $role->getId(),
        ]);
    }

    public function testCreateRoleWithPermissions(): void
    {
        $role = $this->getRoleInstance();
        $role->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);
        $role->save();

        $this->assertDatabaseHas(config('permission.table_names')['roles'], [
            'name'       => $role->getName(),
            'guard_name' => $role->getGuardName(),
            'created_at' => $role->getCreatedAt(),
            'updated_at' => $role->getUpdatedAt(),
        ]);

        foreach ($role->getPermissions() as $permission) {
            $this->assertDatabaseHas(config('permission.table_names')['role_has_permissions'], [
                'permission_id' => $permission->getId(),
                'role_id' => $role->getId(),
            ]);
        }
    }

    public function testExceptionOnCreateRoleWithPermissionsNotAlreadyCreated(): void
    {
        $this->expectException(PermissionIsNotSavedException::class);

        $role = $this->getRoleInstance();
        $role->assignPermissions([
            $this->getPermissionInstance(),
        ]);
    }

    public function testUpdateRole(): void
    {
        $this->expectsEvents(RoleUpdated::class);

        $role = $this->createRole();
        $role->setName('newName');

        $result = $role->save();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);

        $this->assertDatabaseHas(config('permission.table_names')['roles'], [
            'name'       => $role->getName(),
            'guard_name' => $role->getGuardName(),
            'created_at' => $role->getCreatedAt(),
            'updated_at' => $role->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnUpdateRole(): void
    {
        $this->expectException(RoleNameExistsMustBeUniqueException::class);

        $role = $this->createRole();

        $role2 = $this->createRole();
        $role2->setName($role->getName());

        $result = $role2->save();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);
    }

    public function testRemovePermissionFromRole(): void
    {
        $role = $this->createRole();
        $role->assignPermission($this->createPermission('permission1'));
        $role->save();

        $role2 = clone $role;

        $role->removePermission($role2->getPermissions()[0]);
        $role->save();

        $permission = $role2->getPermissions()[0];
        $this->assertDatabaseMissing(config('permission.table_names')['role_has_permissions'], [
            'permission_id' => $permission->getId(),
            'role_id' => $role->getId(),
        ]);
    }

    public function testRemovePermissionsFromRole(): void
    {
        $role = $this->createRole();
        $role->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);
        $role->save();

        $role2 = clone $role;

        $role->removePermissions($role2->getPermissions());
        $role->save();

        foreach ($role2->getPermissions() as $permission) {
            $this->assertDatabaseMissing(config('permission.table_names')['role_has_permissions'], [
                'permission_id' => $permission->getId(),
                'role_id' => $role->getId(),
            ]);
        }
    }

    public function testExceptionOnUpdateRoleWithPermissionsNotAlreadyCreated(): void
    {
        $this->expectException(PermissionIsNotSavedException::class);

        $role = $this->createRole();
        $role->assignPermissions([
            $this->createPermission('permission1'),
            $this->createPermission('permission2'),
        ]);
        $role->save();

        $role->removePermissions([
            $this->getPermissionInstance('permission3'),
        ]);
        $role->save();
    }

    public function testDeleteRole(): void
    {
        $this->expectsEvents(RoleDeleted::class);
        $role = $this->createRole();

        $this->assertTrue(is_int($role->getId()));
        $this->assertTrue($role->getId() !== null);

        $result = $role->delete();

        $this->assertTrue(is_bool($result) === true);
        $this->assertTrue($result === true);

        $this->assertDatabaseMissing(config('permission.table_names')['roles'], [
            'name'       => $role->getName(),
            'guard_name' => $role->getGuardName(),
            'created_at' => $role->getCreatedAt(),
            'updated_at' => $role->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnDeleteRole(): void
    {
        $this->expectException(RoleDoesNotExistsException::class);

        $role = $this->createRole();

        $role->delete();
        $role->delete();
    }

    public function testExceptionOnUpdateDeletedRole()
    {
        $this->expectException(RoleDoesNotExistsException::class);

        $role = $this->createRole();
        $role->delete();

        $role->setName('roleName');
        $role->save();
    }

    public function testExceptionOnDeleteAttachedRole(): void
    {
        $this->expectException(RoleIsAttachedException::class);

        $role = $this->createRole();
        $user = $this->getUserInstance();
        $user->assignRoles([
            $role,
        ]);
        $user->save();

        $role->delete();
    }

    public function testExceptionOnFromArrayRole(): void
    {
        $this->expectException(MethodDoesNotExistsException::class);

        $this->app->make(Role::class)::fromArray([
            'noMethod' => 'noValue',
        ]);
    }
}
