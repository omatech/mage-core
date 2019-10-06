<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class CreateUser
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(User $user): bool
    {
        return app()->make(CreateUserInterface::class)->create($user);
    }
}
