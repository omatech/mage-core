<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface ExistsTranslationInterface
{
    public function exists(TranslationInterface $translation): bool;
}
