<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Models\Permission;

class PermissionBaseRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Permission::class;
    }
}
