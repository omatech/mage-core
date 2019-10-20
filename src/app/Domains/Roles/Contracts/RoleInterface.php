<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

interface RoleInterface
{
    /**
     * Properties.
     */
    public function getId(): ?int;

    public function setId(int $id): Role;

    public function getName(): string;

    public function setName(string $name): Role;

    public function getGuardName(): string;

    public function setGuardName(string $string): Role;

    public function getCreatedAt(): string;

    public function setCreatedAt(string $createdAt): Role;

    public function getUpdatedAt(): string;

    public function setUpdatedAt(string $updatedAt): Role;

    public function getPermissions(): array;

    public function getPermissionsIds(): array;

    /**
     * Methods.
     */
    public static function all(AllRoleInterface $all);

    public static function find(int $id): Role;

    public function save(): bool;

    public function delete(): bool;

    public function assignPermission(PermissionInterface $permission): Role;

    public function assignPermissions(array $permissions): Role;

    public function removePermission(PermissionInterface $permission): Role;

    public function removePermissions(array $permissions): Role;

    public static function fromArray(array $array): Role;
}
