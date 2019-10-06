<?php

namespace Omatech\Mage\Core\Domains\Permissions;

use Illuminate\Contracts\Container\BindingResolutionException;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Features\UpdateOrCreatePermission;
use Omatech\Mage\Core\Domains\Permissions\Features\ExistsAndDeletePermission;
use Omatech\Mage\Core\Domains\Permissions\Features\FindOrFailPermission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\AllPermission;
use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;
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
     * @return Permission
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
     * @return Permission
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
     * @return Permission
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
     * @return Permission
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
     * @return Permission
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param GetAllInterface $all
     * @return mixed
     * @throws BindingResolutionException
     */
    public static function all(GetAllInterface $all)
    {
        return app()->make(AllPermission::class)->make($all);
    }

    /**
     * @param int $id
     * @return Permission
     * @throws BindingResolutionException
     */
    public static function find(int $id): self
    {
        return app()->make(FindOrFailPermission::class)->make($id);
    }

    /**
     * @return bool
     * @throws BindingResolutionException
     */
    public function save(): bool
    {
        return app()->make(UpdateOrCreatePermission::class)->make($this);
    }

    /**
     * @return bool
     * @throws BindingResolutionException
     */
    public function delete(): bool
    {
        return app()->make(ExistsAndDeletePermission::class)->make($this);
    }
}
