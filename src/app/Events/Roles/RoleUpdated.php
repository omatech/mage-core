<?php

namespace Omatech\Mage\Core\Events\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;

class RoleUpdated
{
    public $role;
    public $wasUpdated;

    /**
     * RoleUpdated constructor.
     *
     * @param RoleInterface $role
     * @param bool          $wasUpdated
     */
    public function __construct(RoleInterface $role, bool $wasUpdated)
    {
        $this->role = $role;
        $this->wasUpdated = $wasUpdated;
    }
}
