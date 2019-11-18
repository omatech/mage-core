<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\Jobs\DeleteUser;
use Omatech\Mage\Core\Domains\Users\Jobs\ExistsUser;
use Omatech\Mage\Core\Domains\Users\User;

class ExistsAndDeleteUser
{
    private $exists;
    private $delete;

    /**
     * ExistsAndDeleteUser constructor.
     */
    public function __construct()
    {
        $this->exists = new ExistsUser();
        $this->delete = new DeleteUser();
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserDoesNotExistsException
     */
    public function make(User $user): bool
    {
        $exists = $this->exists->make($user);

        if (false === $exists) {
            throw new UserDoesNotExistsException();
        }

        return $this->delete->make($user);
    }
}
