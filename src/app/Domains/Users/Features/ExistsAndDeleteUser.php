<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Jobs\DeleteUser;
use Omatech\Mage\Core\Domains\Users\Jobs\ExistsUser;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;

class ExistsAndDeleteUser
{
    private $exists;
    private $delete;

    /**
     * ExistsAndDeleteUser constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsUser::class);
        $this->delete = app()->make(DeleteUser::class);
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserDoesNotExistsException
     */
    public function make(User $user): bool
    {
        $exists = $this->exists->make($user);

        if ($exists === false) {
            throw new UserDoesNotExistsException;
        }

        return $this->delete->make($user);
    }
}
