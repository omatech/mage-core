<?php

namespace Omatech\Mage\Core\Events\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;

class RoleDeleted
{
    public $role;
    public $wasDelete;

    /**
     * RoleDeleted constructor.
     */
    public function __construct(RoleInterface $role, bool $wasDelete)
    {
        $this->role = $role;
        $this->wasDelete = $wasDelete;
    }
}
