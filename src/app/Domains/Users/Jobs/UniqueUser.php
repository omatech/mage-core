<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\User;

class UniqueUser
{
    /**
     * @param User $user
     * @return bool
     */
    public function make(User $user): bool
    {
        return resolve(UniqueUserInterface::class)->unique($user);
    }
}
