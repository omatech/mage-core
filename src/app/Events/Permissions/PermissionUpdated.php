<?php

namespace Omatech\Mage\Core\Events\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

class PermissionUpdated
{
    public $permission;
    public $wasUpdated;

    /**
     * PermissionUpdated constructor.
     * @param PermissionInterface $permission
     * @param bool $wasUpdated
     */
    public function __construct(PermissionInterface $permission, bool $wasUpdated)
    {
        $this->permission = $permission;
        $this->wasUpdated = $wasUpdated;
    }
}
