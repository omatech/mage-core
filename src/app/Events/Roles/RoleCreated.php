<?php

namespace Omatech\Mage\Core\Events\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;

class RoleCreated
{
    public $role;
    public $wasRecentlyCreated;

    /**
     * RoleCreated constructor.
     */
    public function __construct(RoleInterface $role, bool $wasRecentlyCreated)
    {
        $this->role = $role;
        $this->wasRecentlyCreated = $wasRecentlyCreated;
    }
}
