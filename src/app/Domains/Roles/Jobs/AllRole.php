<?php

namespace Omatech\Mage\Core\Domains\Roles\Jobs;

use Omatech\Mage\Core\Domains\Roles\Contracts\AllRoleInterface;

class AllRole
{
    /**
     * @param AllRoleInterface $all
     *
     * @return mixed
     */
    public function make(AllRoleInterface $all)
    {
        return $all->get();
    }
}
