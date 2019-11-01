<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class CreateUser
{
    /**
     * @param User $user
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool
     */
    public function make(User $user): bool
    {
        return app()->make(CreateUserInterface::class)->create($user);
    }
}
