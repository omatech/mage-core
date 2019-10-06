<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Permissions\Jobs\FindPermission;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;

class FindOrFailPermission
{
    private $find;

    /**
     * FindOrFailPermission constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->find = app()->make(FindPermission::class);
    }

    /**
     * @param int $id
     * @return Permission
     * @throws PermissionDoesNotExistsException
     */
    public function make(int $id): Permission
    {
        $permission = $this->find->make($id);

        if ($permission === null) {
            throw new PermissionDoesNotExistsException;
        }

        return $permission;
    }
}
