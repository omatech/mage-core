<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Domains\Users\User as UserDomain;
use Omatech\Mage\Core\Models\User as UserModel;

class UserBaseRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return UserModel::class;
    }

    /**
     * @param UserModel $model
     * @param UserDomain $user
     */
    protected function syncPermissions(UserModel $model, UserDomain $user): void
    {
        $model->syncPermissions($user->getPermissionsIds());
    }

    /**
     * @param UserModel $model
     * @param UserDomain $user
     */
    protected function syncRoles(UserModel $model, UserDomain $user): void
    {
        $model->syncRoles($user->getRolesIds());
    }
}
