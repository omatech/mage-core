<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class DeleteUser
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
        return app()->make(DeleteUserInterface::class)->delete($user);
    }
}
