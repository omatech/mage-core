<?php

namespace Omatech\Mage\Core\Domains\Permissions\Jobs;

use Omatech\Mage\Core\Domains\Permissions\Contracts\AllPermissionInterface;

class AllPermission
{
    public function make(AllPermissionInterface $all)
    {
        return $all->get();
    }
}
