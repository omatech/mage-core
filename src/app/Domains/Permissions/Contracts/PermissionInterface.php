<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface PermissionInterface
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
     * @param AllPermissionInterface $all
     * @return mixed
     */
    public static function all(AllPermissionInterface $all);

    /**
     * @param FindPermissionInterface $find
     * @param array $params
     * @return mixed
     */
    public static function find(FindPermissionInterface $find, array $params);

    /**
     * @return bool
     */
    public function save(): bool;

    /**
     * @return bool
     */
    public function delete(): bool;

    /**
     * @param array $array
     * @return mixed
     */
    public static function fromArray(array $array);
}
