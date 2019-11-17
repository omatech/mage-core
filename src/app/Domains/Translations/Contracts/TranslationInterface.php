<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

use Omatech\Mage\Core\Domains\Translations\Translation;

interface TranslationInterface
{
    /**
     * Properties.
     */
    public function getId(): ?int;

    public function setId(int $id): Translation;

    public function getGroup(): string;

    public function getKey(): string;

    public function setKey(string $key): Translation;

    public function setTranslation(string $language, string $text): Translation;

    public function getTranslations(): array;

    public function setTranslations(array $translations): Translation;

    public function getSyncAt(): ?string;

    public function setSyncAt(?string $syncAt): Translation;

    public function getCreatedAt(): string;

    public function setCreatedAt(string $createdAt): Translation;

    public function getUpdatedAt(): string;

    public function setUpdatedAt(string $updatedAt): Translation;

    /**
     * Methods.
     */
    public static function all(AllTranslationInterface $all);

    public static function find(string $key): Translation;

    public function save(): bool;

    public static function fromArray(array $array): Translation;
}
