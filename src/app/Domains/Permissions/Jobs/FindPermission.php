<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class FindPermission
{
    /**
     * @param int $id
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Permission|null
     */
    public function make(int $id): ?Permission
    {
        return app()->make(FindPermissionInterface::class)->find($id);
    }
}
