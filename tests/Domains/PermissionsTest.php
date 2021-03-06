<?php

namespace Omatech\Mage\Core\Tests\Domains;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionAlreadyExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsAttachedException;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionNameExistsMustBeUniqueException;
use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;
use Omatech\Mage\Core\Events\Permissions\PermissionCreated;
use Omatech\Mage\Core\Events\Permissions\PermissionDeleted;
use Omatech\Mage\Core\Events\Permissions\PermissionUpdated;
use Omatech\Mage\Core\Repositories\Permissions\AllPermission;
use Omatech\Mage\Core\Repositories\Permissions\FindPermission;
use Omatech\Mage\Core\Tests\BaseTestCase;

class PermissionsTest extends BaseTestCase
{
    public function testPaginateToArrayPermission(): void
    {
        $pagination = resolve(PermissionInterface::class)::all(new AllPermission());

        $this->assertTrue(true === is_array($pagination));
    }

    public function testFindPermission(): void
    {
        $permission = $this->createPermission();

        $foundPermission = resolve(PermissionInterface::class)::find(new FindPermission(), [
            'id' => $permission->getId(),
        ]);

        $this->assertInstanceOf(PermissionInterface::class, $foundPermission);
        $this->assertSame($foundPermission->getId(), $permission->getId());
    }

    public function testExceptionOnFindPermission(): void
    {
        $this->expectException(PermissionDoesNotExistsException::class);

        resolve(PermissionInterface::class)::find(new FindPermission(), [
            'id' => 1,
        ]);
    }

    public function testCreatePermission(): void
    {
        $this->expectsEvents(PermissionCreated::class);

        $permission = $this->createPermission();

        $this->assertDatabaseHas(config('permission.table_names')['permissions'], [
            'name'       => $permission->getName(),
            'guard_name' => $permission->getGuardName(),
            'created_at' => $permission->getCreatedAt(),
            'updated_at' => $permission->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnCreatePermission(): void
    {
        $this->expectException(PermissionAlreadyExistsException::class);

        $this->createPermission('permission');
        $this->createPermission('permission');
    }

    public function testUpdatePermission(): void
    {
        $this->expectsEvents(PermissionUpdated::class);

        $permission = $this->createPermission();
        $permission->setName('newName');

        $result = $permission->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseHas(config('permission.table_names')['permissions'], [
            'name'       => $permission->getName(),
            'guard_name' => $permission->getGuardName(),
            'created_at' => $permission->getCreatedAt(),
            'updated_at' => $permission->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnUpdatePermission(): void
    {
        $this->expectException(PermissionNameExistsMustBeUniqueException::class);

        $permission = $this->createPermission();

        $permission2 = $this->createPermission();
        $permission2->setName($permission->getName());

        $result = $permission2->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);
    }

    public function testDeletePermission(): void
    {
        $this->expectsEvents(PermissionDeleted::class);

        $permission = $this->createPermission();

        $this->assertTrue(is_int($permission->getId()));
        $this->assertTrue(null !== $permission->getId());

        $result = $permission->delete();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseMissing(config('permission.table_names')['permissions'], [
            'name'       => $permission->getName(),
            'guard_name' => $permission->getGuardName(),
            'created_at' => $permission->getCreatedAt(),
            'updated_at' => $permission->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnDeletePermission(): void
    {
        $this->expectException(PermissionDoesNotExistsException::class);

        $permission = $this->createPermission();

        $permission->delete();
        $permission->delete();
    }

    public function testExceptionOnUpdateDeletedPermission()
    {
        $this->expectException(PermissionDoesNotExistsException::class);

        $permission = $this->createPermission();
        $permission->delete();

        $permission->setName('permissionName');
        $permission->save();
    }

    public function testExceptionOnDeleteAttachedPermission(): void
    {
        $this->expectException(PermissionIsAttachedException::class);

        $permission = $this->createPermission();
        $role = $this->getRoleInstance();
        $role->assignPermissions([
            $permission,
        ]);
        $role->save();

        $permission->delete();
    }

    public function testExceptionOnFromArrayPermission(): void
    {
        $this->expectException(MethodDoesNotExistsException::class);

        resolve(Permission::class)::fromArray([
            'noMethod' => 'noValue',
        ]);
    }
}
