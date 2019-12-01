<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Repositories\RoleBaseRepository;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\AttachedRoleInterface;

class AttachedRole extends RoleBaseRepository implements AttachedRoleInterface
{
    public function attached(RoleInterface $role): bool
    {
        $model = $this->query()->find($role->getId());

        return $model->users->count() > 0;
    }
}
