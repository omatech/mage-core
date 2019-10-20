<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface UpdateTranslationInterface
{
    public function update(TranslationInterface $translation): bool;
}
