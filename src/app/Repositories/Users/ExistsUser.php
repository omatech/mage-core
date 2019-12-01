<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class ExistsUser extends UserBaseRepository implements ExistsUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function exists(UserInterface $user): bool
    {
        return $this->query()
            ->where('email', $user->getEmail())
            ->orWhere('id', $user->getId())
            ->exists();
    }
}
