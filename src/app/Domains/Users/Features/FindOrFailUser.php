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
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->find = app()->make(FindUser::class);
    }

    /**
     * @param int $id
     *
     * @throws UserDoesNotExistsException
     *
     * @return User
     */
    public function make(int $id): User
    {
        $user = $this->find->make($id);

        if (null === $user) {
            throw new UserDoesNotExistsException();
        }

        return $user;
    }
}
