<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class UniqueUser
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
        return app()->make(UniqueUserInterface::class)->unique($user);
    }
}
