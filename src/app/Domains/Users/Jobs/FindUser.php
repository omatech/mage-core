<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;

class FindUser
{
    /**
     * @param int $id
     * @return User|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(int $id): ?User
    {
        return app()->make(FindUserInterface::class)->find($id);
    }
}
