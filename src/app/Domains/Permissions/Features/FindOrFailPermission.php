<?php

namespace Omatech\Mage\Core\Domains\Permissions\Features;

use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionDoesNotExistsException;
use Omatech\Mage\Core\Domains\Permissions\Jobs\FindPermission;

class FindOrFailPermission
{
    private $find;

    /**
     * FindOrFailPermission constructor.
     */
    public function __construct()
    {
        $this->find = new FindPermission();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws PermissionDoesNotExistsException
     */
    public function make(int $id)
    {
        $permission = $this->find->make($id);

        if (null === $permission) {
            throw new PermissionDoesNotExistsException();
        }

        return $permission;
    }
}
