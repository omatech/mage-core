<?php

namespace Omatech\Mage\Core\Repositories\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\CreateRoleInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Events\Roles\RoleCreated;
use Omatech\Mage\Core\Repositories\RoleBaseRepository;

class CreateRole extends RoleBaseRepository implements CreateRoleInterface
{
    public function create(RoleInterface $role): bool
    {
        $created = $this->query()->create([
            'name'       => $role->getName(),
            'guard_name' => $role->getGuardName(),
        ]);

        $role->setId($created->id);
        $role->setCreatedAt($created->created_at);
        $role->setUpdatedAt($created->updated_at);

        $this->syncPermissions($created, $role);

        event(new RoleCreated($role, $created->wasRecentlyCreated));

        return $created->wasRecentlyCreated;
    }
}
