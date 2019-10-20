<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

use Omatech\Mage\Core\Domains\Permissions\Permission;

interface PermissionInterface
{
    /**
     * Properties
     */
    public function getId(): ?int;
    public function setId(int $id): Permission;
    public function getName(): string;
    public function setName(string $name): Permission;
    public function getGuardName(): string;
    public function setGuardName(string $string): Permission;
    public function getCreatedAt(): string;
    public function setCreatedAt(string $createdAt): Permission;
    public function getUpdatedAt(): string;
    public function setUpdatedAt(string $updatedAt): Permission;

    /**
     * Methods
     */
    public static function all(AllPermissionInterface $all);
    public static function find(int $id): Permission;
    public function save(): bool;
    public function delete(): bool;
    public static function fromArray(array $array): Permission;
}
