<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface UpdateUserInterface
{
    public function update(UserInterface $user): bool;
}
