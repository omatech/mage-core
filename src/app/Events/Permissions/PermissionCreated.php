<?php

namespace Omatech\Mage\Core\Events\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

class PermissionCreated
{
    public $permission;
    public $wasRecentlyCreated;

    /**
     * PermissionCreated constructor.
     * @param PermissionInterface $permission
     * @param bool $wasRecentlyCreated
     */
    public function __construct(PermissionInterface $permission, bool $wasRecentlyCreated)
    {
        $this->permission = $permission;
        $this->wasRecentlyCreated = $wasRecentlyCreated;
    }
}
