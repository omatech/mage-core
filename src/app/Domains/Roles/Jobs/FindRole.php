<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Roles\Contracts\FindRoleInterface;

class FindRole
{
    /**
     * @param int $id
     * @return Role|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(int $id): ?Role
    {
        return app()->make(FindRoleInterface::class)->find($id);
    }
}
