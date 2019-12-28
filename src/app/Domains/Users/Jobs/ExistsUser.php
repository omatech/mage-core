<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class ExistsUser
{
    /**
     * @param User $user
     * @return bool
     */
    public function make(User $user): bool
    {
        return resolve(ExistsUserInterface::class)->exists($user);
    }
}
