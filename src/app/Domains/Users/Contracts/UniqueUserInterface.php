<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface UniqueUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function unique(UserInterface $user): bool;
}
