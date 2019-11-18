<?php

namespace Omatech\Mage\Core\Domains\Users;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Shared\Traits\PermissionsManager;
use Omatech\Mage\Core\Domains\Shared\Traits\RolesManager;
use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Users\Features\ExistsAndDeleteUser;
use Omatech\Mage\Core\Domains\Users\Features\FindOrFailUser;
use Omatech\Mage\Core\Domains\Users\Features\UpdateOrCreateUser;
use Omatech\Mage\Core\Domains\Users\Jobs\AllUser;

class User implements UserInterface
{
    use FromArray;
    use PermissionsManager;
    use RolesManager;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return User
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return User
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @return User
     */
    public function setEmailVerifiedAt(?string $emailVerifiedAt): self
    {
        $this->emailVerifiedAt = $emailVerifiedAt;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    /**
     * @return User
     */
    public function setRememberToken(?string $rememberToken): self
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return User
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @return User
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPermissionsIds(): array
    {
        return array_map(static function (PermissionInterface $permission) {
            return $permission->getId();
        }, $this->getPermissions());
    }

    public function getRolesIds(): array
    {
        return array_map(static function (RoleInterface $role) {
            return $role->getId();
        }, $this->getRoles());
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public static function all(AllUserInterface $all)
    {
        return app()->make(AllUser::class)->make($all);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return User
     */
    public static function find(int $id)
    {
        return app()->make(FindOrFailUser::class)->make($id);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function save(): bool
    {
        return app()->make(UpdateOrCreateUser::class)->make($this);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function delete(): bool
    {
        return app()->make(ExistsAndDeleteUser::class)->make($this);
    }
}
