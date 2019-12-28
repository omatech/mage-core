<?php

namespace Omatech\Mage\Core\Domains\Roles\Contracts;

interface FindRoleInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function find(array $params);
}
