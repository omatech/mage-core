<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface ImportTranslationInterface
{
    /**
     * @param string $path
     * @param string $locale
     * @return array
     */
    public function import(string $path, string $locale = ''): array;
}
