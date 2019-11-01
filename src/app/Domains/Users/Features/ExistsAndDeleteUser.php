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
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsUser::class);
        $this->delete = app()->make(DeleteUser::class);
    }

    /**
     * @param User $user
     *
     * @throws UserDoesNotExistsException
     *
     * @return bool
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
