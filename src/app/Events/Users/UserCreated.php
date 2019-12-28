<?php

namespace Omatech\Mage\Core\Events\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;

class UserCreated
{
    public $user;
    public $wasRecentlyCreated;

    /**
     * UserCreated constructor.
     */
    public function __construct(UserInterface $user, bool $wasRecentlyCreated)
    {
        $this->user = $user;
        $this->wasRecentlyCreated = $wasRecentlyCreated;
    }
}
