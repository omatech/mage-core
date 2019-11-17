<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface ImportTranslationInterface
{
    public function import(string $path, string $locale = ''): array;
}
