<?php

namespace Omatech\Mage\Core\Domains\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Features\ExistsAndDeletePermission;
use Omatech\Mage\Core\Domains\Permissions\Features\FindOrFailPermission;
use Omatech\Mage\Core\Domains\Permissions\Features\UpdateOrCreatePermission;
use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;

class Permission implements PermissionInterface
{
    use FromArray;

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
     * @param AllPermissionInterface $all
     * @return mixed
     */
    public static function all(AllPermissionInterface $all)
    {
        return $all->get();
    }

    /**
     * @param FindPermissionInterface $find
     * @param array $params
     * @return mixed
     * @throws Exceptions\PermissionDoesNotExistsException
     */
    public static function find(FindPermissionInterface $find, array $params)
    {
        return (new FindOrFailPermission())->make($find, $params);
    }

    /**
     * @return bool
     * @throws Exceptions\PermissionAlreadyExistsException
     * @throws Exceptions\PermissionDoesNotExistsException
     * @throws Exceptions\PermissionNameExistsMustBeUniqueException
     */
    public function save(): bool
    {
        return (new UpdateOrCreatePermission())->make($this);
    }

    /**
     * @return bool
     * @throws Exceptions\PermissionDoesNotExistsException
     * @throws Exceptions\PermissionIsAttachedException
     */
    public function delete(): bool
    {
        return (new ExistsAndDeletePermission())->make($this);
    }
}
