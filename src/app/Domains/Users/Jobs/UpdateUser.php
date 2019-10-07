<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class UpdateUser
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(User $user): bool
    {
        return app()->make(UpdateUserInterface::class)->update($user);
    }
}