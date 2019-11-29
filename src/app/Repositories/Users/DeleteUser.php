<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Events\Users\UserDeleted;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class DeleteUser extends UserBaseRepository implements DeleteUserInterface
{
    public function delete(UserInterface $user): bool
    {
        $isDeleted = $this->query()
            ->where('id', $user->getId())
            ->delete();

        $isDeleted = $isDeleted > 0;

        event(new UserDeleted($user, $isDeleted));

        return $isDeleted;
    }
}
