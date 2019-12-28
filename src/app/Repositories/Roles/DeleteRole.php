<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\DeleteRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Events\Roles\RoleDeleted;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class DeleteRole extends RoleBaseRepository implements DeleteRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function delete(RoleInterface $role): bool
    {
        $isDeleted = $this->query()
            ->where('id', $role->getId())
            ->delete();

        event(new RoleDeleted($role, $isDeleted > 0));

        return $isDeleted > 0;
    }
}
