<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class AllUser extends UserBaseRepository implements AllUserInterface
{
    /**
     * @return mixed
     */
    public function get()
    {
        return $this->query()
            ->paginate()
            ->toArray();
    }
}
