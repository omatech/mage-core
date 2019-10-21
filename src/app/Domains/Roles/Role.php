<?php

namespace Omatech\Mage\Core\Domains\Roles;

use Omatech\Mage\Core\Domains\Roles\Jobs\AllRole;
use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Permissions\PermissionModel;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Features\FindOrFailRole;
use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Features\UpdateOrCreateRole;
use Omatech\Mage\Core\Domains\Roles\Features\ExistsAndDeleteRole;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

class Role implements RoleInterface
{
    use FromArray;

    private $id;
    private $name;
    private $guardName;
    private $createdAt;
    private $updatedAt;
    private $permissions = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Role
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuardName(): string
    {
        return $this->guardName;
    }

    /**
     * @param string $guardName
     * @return Role
     */
    public function setGuardName(string $guardName): self
    {
        $this->guardName = $guardName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return Role
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     * @return Role
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return array
     */
    public function getPermissionsIds(): array
    {
        return array_map(static function (PermissionInterface $permission) {
            return $permission->getId();
        }, $this->getPermissions());
    }

    /**
     * @param AllRoleInterface $all
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function all(AllRoleInterface $all)
    {
        return app()->make(AllRole::class)->make($all);
    }

    /**
     * @param int $id
     * @return Role
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function find(int $id): self
    {
        return app()->make(FindOrFailRole::class)->make($id);
    }

    /**
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function save(): bool
    {
        return app()->make(UpdateOrCreateRole::class)->make($this);
    }

    /**
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function delete(): bool
    {
        return app()->make(ExistsAndDeleteRole::class)->make($this);
    }

    /**
     * @param PermissionInterface $permission
     * @return Role
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function assignPermission(PermissionInterface $permission): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->assignPermission($this->getPermissions(), $permission);

        return $this;
    }

    /**
     * @param array $permissions
     * @return Role
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function assignPermissions(array $permissions): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->assignPermissions($this->getPermissions(), $permissions);

        return $this;
    }

    /**
     * @param PermissionInterface $permission
     * @return Role
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function removePermission(PermissionInterface $permission): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->removePermission($this->getPermissions(), $permission);

        return $this;
    }

    /**
     * @param array $permissions
     * @return Role
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function removePermissions(array $permissions): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->removePermissions($this->getPermissions(), $permissions);

        return $this;
    }
}
