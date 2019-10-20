<?php

namespace Omatech\Mage\Core\Domains\Users\Jobs;

use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;

class AllUser
{
    public function make(AllUserInterface $all)
    {
        return $all->get();
    }
}
