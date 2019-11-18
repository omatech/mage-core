<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface UpdateUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function update(UserInterface $user): bool;
}
