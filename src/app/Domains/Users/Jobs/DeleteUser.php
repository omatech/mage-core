<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;

class DeleteUser
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(User $user): bool
    {
        return app()->make(DeleteUserInterface::class)->delete($user);
    }
}
