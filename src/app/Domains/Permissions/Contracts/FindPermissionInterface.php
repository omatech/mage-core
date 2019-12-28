<?php

namespace Omatech\Mage\Core\Domains\Permissions\Contracts;

interface FindPermissionInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function find(array $params);
}
