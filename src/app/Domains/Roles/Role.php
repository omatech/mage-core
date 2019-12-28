<?php

namespace Omatech\Mage\Core\Domains\Roles;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Features\ExistsAndDeleteRole;
use Omatech\Mage\Core\Domains\Roles\Features\FindOrFailRole;
use Omatech\Mage\Core\Domains\Roles\Features\UpdateOrCreateRole;
use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Shared\Traits\PermissionsManager;

class Role implements RoleInterface
{
    use FromArray;
    use PermissionsManager;

    private $id;
    private $name;
    private $guardName;
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
     * @return $this
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
     * @return $this
     */
    public function setName(string $name)
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
     * @return $this
     */
    public function setGuardName(string $guardName)
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
     * @return $this
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
     * @return $this
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
    public function getPermissionsIds(): array
    {
        return array_map(static function (PermissionInterface $permission) {
            return $permission->getId();
        }, $this->getPermissions());
    }

    /**
     * @param AllRoleInterface $all
     * @return mixed
     */
    public static function all(AllRoleInterface $all)
    {
        return $all->get();
    }

    /**
     * @param FindRoleInterface $find
     * @param array $params
     * @return mixed
     * @throws Exceptions\RoleDoesNotExistsException
     */
    public static function find(FindRoleInterface $find, array $params)
    {
        return (new FindOrFailRole())->make($find, $params);
    }

    /**
     * @return bool
     * @throws Exceptions\RoleAlreadyExistsException
     * @throws Exceptions\RoleDoesNotExistsException
     * @throws Exceptions\RoleNameExistsMustBeUniqueException
     */
    public function save(): bool
    {
        return (new UpdateOrCreateRole())->make($this);
    }

    /**
     * @return bool
     * @throws Exceptions\RoleDoesNotExistsException
     * @throws Exceptions\RoleIsAttachedException
     */
    public function delete(): bool
    {
        return (new ExistsAndDeleteRole())->make($this);
    }
}
