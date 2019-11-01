<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Role;

class FindRole
{
    /**
     * @param int $id
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Role|null
     */
    public function make(int $id): ?Role
    {
        return app()->make(FindRoleInterface::class)->find($id);
    }
}
