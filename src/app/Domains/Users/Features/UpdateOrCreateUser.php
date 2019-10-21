<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Domains\Users\Jobs\CreateUser;
use Omatech\Mage\Core\Domains\Users\Jobs\ExistsUser;
use Omatech\Mage\Core\Domains\Users\Jobs\UniqueUser;
use Omatech\Mage\Core\Domains\Users\Jobs\UpdateUser;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserAlreadyExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserNameExistsMustBeUniqueException;

class UpdateOrCreateUser
{
    private $exists;
    private $create;
    private $update;
    private $unique;

    /**
     * UpdateOrCreateUser constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsUser::class);
        $this->create = app()->make(CreateUser::class);
        $this->update = app()->make(UpdateUser::class);
        $this->unique = app()->make(UniqueUser::class);
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserAlreadyExistsException
     * @throws UserNameExistsMustBeUniqueException
     */
    public function make(User $user): bool
    {
        if ($user->getId() !== null) {
            return $this->update($user);
        }

        return $this->create($user);
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserAlreadyExistsException
     */
    private function create(User $user): bool
    {
        $exists = $this->exists->make($user);

        if ($exists === true) {
            throw new UserAlreadyExistsException;
        }

        return $this->create->make($user);
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserNameExistsMustBeUniqueException
     * @throws UserDoesNotExistsException
     */
    private function update(User $user): bool
    {
        $exists = $this->unique->make($user);

        if ($exists === true) {
            throw new UserNameExistsMustBeUniqueException;
        }

        $exists = $this->exists->make($user);

        if ($exists === false) {
            throw new UserDoesNotExistsException;
        }

        return $this->update->make($user);
    }
}
