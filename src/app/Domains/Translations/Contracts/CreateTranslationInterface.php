<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface CreateTranslationInterface
{
    public function create(TranslationInterface $translation): bool;
}
