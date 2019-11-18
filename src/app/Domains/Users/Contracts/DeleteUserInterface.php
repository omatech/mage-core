<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface DeleteUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function delete(UserInterface $user): bool;
}
