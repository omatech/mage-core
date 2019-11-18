<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface ExistsUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function exists(UserInterface $user): bool;
}
