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
     */
    public function setId(int $id);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getGuardName(): string;

    /**
     * @param string $string
     */
    public function setGuardName(string $string);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
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
     */
    public static function all(AllRoleInterface $all);

    /**
     * @param FindRoleInterface $find
     * @param array $params
     */
    public static function find(FindRoleInterface $find, array $params);

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
     */
    public function assignPermission(PermissionInterface $permission);

    /**
     * @param array $permissions
     */
    public function assignPermissions(array $permissions);

    /**
     * @param PermissionInterface $permission
     */
    public function removePermission(PermissionInterface $permission);

    /**
     * @param array $permissions
     */
    public function removePermissions(array $permissions);

    /**
     * @param array $array
     */
    public static function fromArray(array $array);
}
