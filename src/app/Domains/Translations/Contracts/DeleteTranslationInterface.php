<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface DeleteTranslationInterface
{
    public function delete(TranslationInterface $translation): bool;
}
