<?php

namespace Omatech\Mage\Core\Repositories\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;
use Omatech\Mage\Core\Repositories\PermissionBaseRepository;

class AllPermission extends PermissionBaseRepository implements AllPermissionInterface
{
    public function get()
    {
        return $this->query()
            ->paginate()
            ->toArray();
    }
}
