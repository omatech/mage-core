<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Shared\Contracts\GetAllInterface;

class AllUser
{
    /**
     * @param GetAllInterface $all
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(GetAllInterface $all)
    {
        return app()->make(AllUserInterface::class)->get($all);
    }
}
