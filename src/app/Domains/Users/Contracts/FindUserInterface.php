<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface FindUserInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);
}
