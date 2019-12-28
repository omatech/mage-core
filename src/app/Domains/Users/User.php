<?php

namespace Omatech\Mage\Core\Domains\Users;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Shared\Traits\PermissionsManager;
use Omatech\Mage\Core\Domains\Shared\Traits\RolesManager;
use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Users\Features\ExistsAndDeleteUser;
use Omatech\Mage\Core\Domains\Users\Features\FindOrFailUser;
use Omatech\Mage\Core\Domains\Users\Features\UpdateOrCreateUser;

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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this|mixed
     */
    public function setId(int $id)
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
     * @return $this|mixed
     */
    public function setName(string $name)
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
     * @return $this|mixed
     */
    public function setLanguage(string $language)
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
     * @return $this|mixed
     */
    public function setEmail(string $email)
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
     * @return $this|mixed
     */
    public function setEmailVerifiedAt(?string $emailVerifiedAt)
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
     * @return $this|mixed
     */
    public function setPassword(string $password)
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
     * @return $this|mixed
     */
    public function setRememberToken(?string $rememberToken)
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
     * @return $this|mixed
     */
    public function setCreatedAt(string $createdAt)
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
     * @return $this|mixed
     */
    public function setUpdatedAt(string $updatedAt)
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
     */
    public static function all(AllUserInterface $all)
    {
        return $all->get();
    }

    /**
     * @param FindUserInterface $find
     * @param array $params
     * @return mixed|User|null
     * @throws Exceptions\UserDoesNotExistsException
     */
    public static function find(FindUserInterface $find, array $params)
    {
        return (new FindOrFailUser())->make($find, $params);
    }

    /**
     * @return bool
     * @throws Exceptions\UserAlreadyExistsException
     * @throws Exceptions\UserDoesNotExistsException
     * @throws Exceptions\UserNameExistsMustBeUniqueException
     */
    public function save(): bool
    {
        return (new UpdateOrCreateUser())->make($this);
    }

    /**
     * @return bool
     * @throws Exceptions\UserDoesNotExistsException
     */
    public function delete(): bool
    {
        return (new ExistsAndDeleteUser())->make($this);
    }
}
