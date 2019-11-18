<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Users\User;

interface UserInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $id
     * @return mixed
     */
    public function setId(int $id);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getLanguage(): string;

    /**
     * @param string $language
     * @return mixed
     */
    public function setLanguage(string $language);

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return mixed
     */
    public function setEmail(string $email);

    /**
     * @return string|null
     */
    public function getEmailVerifiedAt(): ?string;

    /**
     * @param string|null $emailVerifiedAt
     * @return mixed
     */
    public function setEmailVerifiedAt(?string $emailVerifiedAt);

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     * @return mixed
     */
    public function setPassword(string $password);

    /**
     * @return string|null
     */
    public function getRememberToken(): ?string;

    /**
     * @param string|null $rememberToken
     * @return mixed
     */
    public function setRememberToken(?string $rememberToken);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return mixed
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return mixed
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * @return array
     */
    public function getPermissions(): array;

    /**
     * @return array
     */
    public function getRoles(): array;

    /**
     * @return array
     */
    public function getPermissionsIds(): array;

    /**
     * @return array
     */
    public function getRolesIds(): array;

    /**
     * @param AllUserInterface $all
     * @return mixed
     */
    public static function all(AllUserInterface $all);

    /**
     * @param int $id
     * @return mixed
     */
    public static function find(int $id);

    /**
     * @return bool
     */
    public function save(): bool;

    /**
     * @return bool
     */
    public function delete(): bool;

    /**
     * @param PermissionInterface $permission
     * @return mixed
     */
    public function assignPermission(PermissionInterface $permission);

    /**
     * @param array $permissions
     * @return mixed
     */
    public function assignPermissions(array $permissions);

    /**
     * @param PermissionInterface $permission
     * @return mixed
     */
    public function removePermission(PermissionInterface $permission);

    /**
     * @param array $permissions
     * @return mixed
     */
    public function removePermissions(array $permissions);

    /**
     * @param RoleInterface $role
     * @return mixed
     */
    public function assignRole(RoleInterface $role);

    /**
     * @param array $roles
     * @return mixed
     */
    public function assignRoles(array $roles);

    /**
     * @param RoleInterface $role
     * @return mixed
     */
    public function removeRole(RoleInterface $role);

    /**
     * @param array $roles
     * @return mixed
     */
    public function removeRoles(array $roles);

    /**
     * @param array $array
     * @return mixed
     */
    public static function fromArray(array $array);
}
