<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Jobs\FindUser;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;

class FindOrFailUser
{
    private $find;

    /**
     * FindOrFailUser constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->find = app()->make(FindUser::class);
    }

    /**
     * @param int $id
     * @return User
     * @throws UserDoesNotExistsException
     */
    public function make(int $id): User
    {
        $user = $this->find->make($id);

        if ($user === null) {
            throw new UserDoesNotExistsException;
        }

        return $user;
    }
}
