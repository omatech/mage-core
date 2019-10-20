<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;

interface TranslationInterface
{
    /**
     * Properties
     */

    public function setKey(string $key): Translation;
    public function setTranslation(string $language, string $text): Translation;
    public function setTranslations(array $translations): Translation;

    /**
     * Methods
     */

    public static function all(AllTranslationInterface $all);
    public static function find(int $id): Translation;

    public function save(): bool;
}
