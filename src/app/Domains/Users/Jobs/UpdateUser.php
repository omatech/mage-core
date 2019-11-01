<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class UpdateUser
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
        return app()->make(UpdateUserInterface::class)->update($user);
    }
}
