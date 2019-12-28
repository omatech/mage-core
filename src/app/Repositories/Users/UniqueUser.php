<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class UniqueUser extends UserBaseRepository implements UniqueUserInterface
{
    public function unique(UserInterface $user): bool
    {
        return $this->query()
            ->where('email', $user->getEmail())
            ->where('id', '!=', $user->getId())
            ->exists();
    }
}
