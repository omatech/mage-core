<?php

namespace Omatech\Mage\Core\Events\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;

class UserUpdated
{
    public $user;
    public $wasUpdated;

    /**
     * UserUpdated constructor.
     */
    public function __construct(UserInterface $user, bool $wasUpdated)
    {
        $this->user = $user;
        $this->wasUpdated = $wasUpdated;
    }
}
