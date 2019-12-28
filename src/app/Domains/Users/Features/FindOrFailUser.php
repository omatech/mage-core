<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\User;

class FindOrFailUser
{
    /**
     * @param FindUserInterface $find
     * @param $params
     * @return User|null
     * @throws UserDoesNotExistsException
     */
    public function make(FindUserInterface $find, $params)
    {
        $user = $find->find($params);

        if (null === $user) {
            throw new UserDoesNotExistsException();
        }

        return $user;
    }
}
