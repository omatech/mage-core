<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface ExistsTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function exists(TranslationInterface $translation): bool;
}
