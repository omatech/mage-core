<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\UpdateRoleInterface;
use Omatech\Mage\Core\Events\Roles\RoleUpdated;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class UpdateRole extends RoleBaseRepository implements UpdateRoleInterface
{
    public function update(RoleInterface $role): bool
    {
        $updated = $this->query()->find($role->getId());

        $updated->fill([
                'name'       => $role->getName(),
                'guard_name' => $role->getGuardName(),
            ])->save();

        $role->setCreatedAt($updated->created_at);
        $role->setUpdatedAt($updated->updated_at);

        $this->syncPermissions($updated, $role);

        event(new RoleUpdated($role, count($updated->getChanges()) >= 1));

        return count($updated->getChanges()) >= 1;
    }
}
