<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Domains\Roles\Role as RoleDomain;
use Omatech\Mage\Core\Models\Role as RoleModel;

class RoleBaseRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return RoleModel::class;
    }

    /**
     * @param RoleModel $model
     * @param RoleDomain $role
     */
    protected function syncPermissions(RoleModel $model, RoleDomain $role): void
    {
        $model->syncPermissions($role->getPermissionsIds());
    }
}
