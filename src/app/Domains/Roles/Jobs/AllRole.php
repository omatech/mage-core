<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;
use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;

class AllRole
{
    /**
     * @param GetAllInterface $all
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(GetAllInterface $all)
    {
        return app()->make(AllRoleInterface::class)->get($all);
    }
}
