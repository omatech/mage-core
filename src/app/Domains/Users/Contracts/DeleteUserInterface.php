<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface DeleteUserInterface
{
    public function delete(UserInterface $user): bool;
}
