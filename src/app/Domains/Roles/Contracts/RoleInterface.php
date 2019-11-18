<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

interface RoleInterface
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
    public function getGuardName(): string;

    /**
     * @param string $string
     * @return mixed
     */
    public function setGuardName(string $string);

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
    public function getPermissionsIds(): array;

    /**
     * @param AllRoleInterface $all
     * @return mixed
     */
    public static function all(AllRoleInterface $all);

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
     * @param array $array
     * @return mixed
     */
    public static function fromArray(array $array);
}
