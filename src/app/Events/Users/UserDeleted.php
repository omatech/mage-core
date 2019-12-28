<?php

namespace Omatech\Mage\Core\Events\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;

class UserDeleted
{
    public $user;
    public $wasDelete;

    /**
     * UserDeleted constructor.
     */
    public function __construct(UserInterface $user, bool $wasDelete)
    {
        $this->user = $user;
        $this->wasDelete = $wasDelete;
    }
}
