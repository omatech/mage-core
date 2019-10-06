<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface UniqueUserInterface
{
    public function unique(UserInterface $user): bool;
}
