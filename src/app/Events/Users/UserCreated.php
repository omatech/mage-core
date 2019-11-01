<?php

namespace Omatech\Mage\Core\Events\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;

class UserCreated
{
    public $user;
    public $wasRecentlyCreated;

    /**
     * UserCreated constructor.
     *
     * @param UserInterface $user
     * @param bool          $wasRecentlyCreated
     */
    public function __construct(UserInterface $user, bool $wasRecentlyCreated)
    {
        $this->user = $user;
        $this->wasRecentlyCreated = $wasRecentlyCreated;
    }
}
