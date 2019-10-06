<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;

class UniqueUser
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(User $user): bool
    {
        return app()->make(UniqueUserInterface::class)->unique($user);
    }
}
