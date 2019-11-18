<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Users\User;

interface UserInterface
{
    /**
     * Properties.
     */
    public function getId(): ?int;

    public function setId(int $id): User;

    public function getName(): string;

    public function setName(string $name): User;

    public function getLanguage(): string;

    public function setLanguage(string $language): User;

    public function getEmail(): string;

    public function setEmail(string $email): User;

    public function getEmailVerifiedAt(): ?string;

    public function setEmailVerifiedAt(?string $emailVerifiedAt): User;

    public function getPassword(): string;

    public function setPassword(string $password): User;

    public function getRememberToken(): ?string;

    public function setRememberToken(?string $rememberToken): User;

    public function getCreatedAt(): string;

    public function setCreatedAt(string $createdAt): User;

    public function getUpdatedAt(): string;

    public function setUpdatedAt(string $updatedAt): User;

    public function getPermissions(): array;

    public function getRoles(): array;

    public function getPermissionsIds(): array;

    public function getRolesIds(): array;

    /**
     * Methods.
     */
    public static function all(AllUserInterface $all);

    public static function find(int $id);

    public function save(): bool;

    public function delete(): bool;

    public function assignPermission(PermissionInterface $permission): User;

    public function assignPermissions(array $permissions): User;

    public function removePermission(PermissionInterface $permission): User;

    public function removePermissions(array $permissions): User;

    public function assignRole(RoleInterface $role): User;

    public function assignRoles(array $roles): User;

    public function removeRole(RoleInterface $role): User;

    public function removeRoles(array $roles): User;

    public static function fromArray(array $array): User;
}
