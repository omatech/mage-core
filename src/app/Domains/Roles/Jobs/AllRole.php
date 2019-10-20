<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;

class AllRole
{
    public function make(AllRoleInterface $all)
    {
        return $all->get();
    }
}
