<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class ExistsUser
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
        return app()->make(ExistsUserInterface::class)->exists($user);
    }
}
