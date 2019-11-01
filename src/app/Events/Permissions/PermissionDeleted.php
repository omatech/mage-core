<?php

namespace Omatech\Mage\Core\Events\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;

class PermissionDeleted
{
    public $permission;
    public $wasDelete;

    /**
     * PermissionDeleted constructor.
     *
     * @param PermissionInterface $permission
     * @param bool                $wasDelete
     */
    public function __construct(PermissionInterface $permission, bool $wasDelete)
    {
        $this->permission = $permission;
        $this->wasDelete = $wasDelete;
    }
}
