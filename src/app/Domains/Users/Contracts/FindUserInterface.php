<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface FindUserInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function find(array $params);
}
