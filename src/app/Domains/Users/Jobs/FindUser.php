<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class FindUser
{
    /**
     * @param int $id
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return User|null
     */
    public function make(int $id): ?User
    {
        return app()->make(FindUserInterface::class)->find($id);
    }
}
