<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;

class ExistsUser
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(User $user): bool
    {
        return app()->make(ExistsUserInterface::class)->exists($user);
    }
}
