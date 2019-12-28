<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\AttachedRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class AttachedRole extends RoleBaseRepository implements AttachedRoleInterface
{
    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function attached(RoleInterface $role): bool
    {
        $model = $this->query()->find($role->getId());

        return $model->users->count() > 0;
    }
}
