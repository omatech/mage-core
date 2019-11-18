<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface FindPermissionInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);
}
