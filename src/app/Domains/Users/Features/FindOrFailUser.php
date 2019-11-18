<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\Jobs\FindUser;
use Omatech\Mage\Core\Domains\Users\User;

class FindOrFailUser
{
    private $find;

    /**
     * FindOrFailUser constructor.
     */
    public function __construct()
    {
        $this->find = new FindUser();
    }

    /**
     * @param int $id
     * @return User|null
     * @throws UserDoesNotExistsException
     */
    public function make(int $id)
    {
        $user = $this->find->make($id);

        if (null === $user) {
            throw new UserDoesNotExistsException();
        }

        return $user;
    }
}
