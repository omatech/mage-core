<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\FindPermissionInterface;

class FindPermission
{
    /**
     * @param int $id
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function make(int $id)
    {
        return app()->make(FindPermissionInterface::class)->find($id);
    }
}
