<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface ExistsUserInterface
{
    public function exists(UserInterface $user): bool;
}
