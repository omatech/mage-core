<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface FindRoleInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);
}
