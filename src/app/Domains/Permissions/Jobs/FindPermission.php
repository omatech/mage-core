<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;

class FindPermission
{
    /**
     * @param int $id
     * @return Permission|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(int $id): ?Permission
    {
        return app()->make(FindPermissionInterface::class)->find($id);
    }
}
