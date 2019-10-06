<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface CreateUserInterface
{
    public function create(UserInterface $user): bool;
}
