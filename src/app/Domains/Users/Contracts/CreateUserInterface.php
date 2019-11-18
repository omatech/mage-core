<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface CreateUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function create(UserInterface $user): bool;
}
