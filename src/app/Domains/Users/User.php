<?php

namespace Omatech\Mage\Core\Domains\Users;

use Omatech\Mage\Core\Domains\Roles\RoleModel;
use Omatech\Mage\Core\Domains\Users\Jobs\AllUser;
use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Permissions\PermissionModel;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Users\Features\FindOrFailUser;
use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Users\Features\UpdateOrCreateUser;
use Omatech\Mage\Core\Domains\Users\Features\ExistsAndDeleteUser;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException;

class User implements UserInterface
{
    use FromArray;

    private $id;
    private $name;
    private $language;
    private $email;
    private $emailVerifiedAt;
    private $password;
    private $rememberToken;
    private $createdAt;
    private $updatedAt;
    private $permissions = [];
    private $roles = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
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
     * @return User
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return User
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param string|null $emailVerifiedAt
     * @return User
     */
    public function setEmailVerifiedAt(?string $emailVerifiedAt): self
    {
        $this->emailVerifiedAt = $emailVerifiedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    /**
     * @param string|null $rememberToken
     * @return User
     */
    public function setRememberToken(?string $rememberToken): self
    {
        $this->rememberToken = $rememberToken;

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
     * @return User
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
     * @return User
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
    public function getRoles(): array
    {
        return $this->roles;
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
     * @return array
     */
    public function getRolesIds(): array
    {
        return array_map(static function (RoleInterface $role) {
            return $role->getId();
        }, $this->getRoles());
    }

    /**
     * @param AllUserInterface $all
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function all(AllUserInterface $all)
    {
        return app()->make(AllUser::class)->make($all);
    }

    /**
     * @param int $id
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function find(int $id): self
    {
        return app()->make(FindOrFailUser::class)->make($id);
    }

    /**
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function save(): bool
    {
        return app()->make(UpdateOrCreateUser::class)->make($this);
    }

    /**
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function delete(): bool
    {
        return app()->make(ExistsAndDeleteUser::class)->make($this);
    }

    /**
     * @param PermissionInterface $permission
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function removePermissions(array $permissions): self
    {
        $this->permissions = app()->make(PermissionModel::class)
            ->removePermissions($this->getPermissions(), $permissions);

        return $this;
    }

    /**
     * @param RoleInterface $role
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function assignRole(RoleInterface $role): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->assignRole($this->getRoles(), $role);

        return $this;
    }

    /**
     * @param array $roles
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function assignRoles(array $roles): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->assignRoles($this->getRoles(), $roles);

        return $this;
    }

    /**
     * @param RoleInterface $role
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function removeRole(RoleInterface $role): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->removeRole($this->getRoles(), $role);

        return $this;
    }

    /**
     * @param array $roles
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function removeRoles(array $roles): self
    {
        $this->roles = app()->make(RoleModel::class)
            ->removeRoles($this->getRoles(), $roles);

        return $this;
    }
}
