<?php

namespace Omatech\Mage\Core\Domains\Users\Contracts;

interface FindUserInterface
{
    public function find(int $id): ?UserInterface;
}
