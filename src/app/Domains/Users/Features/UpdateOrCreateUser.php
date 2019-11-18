<?php

namespace Omatech\Mage\Core\Domains\Users\Features;

use Omatech\Mage\Core\Domains\Users\Exceptions\UserAlreadyExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserDoesNotExistsException;
use Omatech\Mage\Core\Domains\Users\Exceptions\UserNameExistsMustBeUniqueException;
use Omatech\Mage\Core\Domains\Users\Jobs\CreateUser;
use Omatech\Mage\Core\Domains\Users\Jobs\ExistsUser;
use Omatech\Mage\Core\Domains\Users\Jobs\UniqueUser;
use Omatech\Mage\Core\Domains\Users\Jobs\UpdateUser;
use Omatech\Mage\Core\Domains\Users\User;

class UpdateOrCreateUser
{
    private $exists;
    private $create;
    private $update;
    private $unique;

    /**
     * UpdateOrCreateUser constructor.
     */
    public function __construct()
    {
        $this->exists = new ExistsUser();
        $this->create = new CreateUser();
        $this->update = new UpdateUser();
        $this->unique = new UniqueUser();
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserAlreadyExistsException
     * @throws UserDoesNotExistsException
     * @throws UserNameExistsMustBeUniqueException
     */
    public function make(User $user): bool
    {
        if (null !== $user->getId()) {
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

        if (true === $exists) {
            throw new UserAlreadyExistsException();
        }

        return $this->create->make($user);
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserDoesNotExistsException
     * @throws UserNameExistsMustBeUniqueException
     */
    private function update(User $user): bool
    {
        $exists = $this->unique->make($user);

        if (true === $exists) {
            throw new UserNameExistsMustBeUniqueException();
        }

        $exists = $this->exists->make($user);

        if (false === $exists) {
            throw new UserDoesNotExistsException();
        }

        return $this->update->make($user);
    }
}
