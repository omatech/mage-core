<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;
use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;

class AllPermission
{
    /**
     * @param GetAllInterface $all
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(GetAllInterface $all)
    {
        return app()->make(AllPermissionInterface::class)->get($all);
    }
}
