<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface TranslationInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $id
     * @return mixed
     */
    public function setId(int $id);

    /**
     * @return string
     */
    public function getGroup(): string;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param string $key
     * @return mixed
     */
    public function setKey(string $key);

    /**
     * @param string $language
     * @param string $text
     * @return mixed
     */
    public function setTranslation(string $language, string $text);

    /**
     * @return array
     */
    public function getTranslations(): array;

    /**
     * @param array $translations
     * @return mixed
     */
    public function setTranslations(array $translations);

    /**
     * @return string|null
     */
    public function getSyncAt(): ?string;

    /**
     * @param string|null $syncAt
     * @return mixed
     */
    public function setSyncAt(?string $syncAt);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return mixed
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return mixed
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * @param AllTranslationInterface $all
     * @return mixed
     */
    public static function all(AllTranslationInterface $all);

    /**
     * @param FindTranslationInterface $find
     * @param array $params
     * @return mixed
     */
    public static function find(FindTranslationInterface $find, array $params);

    /**
     * @return bool
     */
    public function save(): bool;

    /**
     * @return bool
     */
    public function delete(): bool;

    /**
     * @param AllTranslationInterface $all
     * @param ExportTranslationInterface $export
     * @param array|null $locales
     * @return mixed
     */
    public static function export(
        AllTranslationInterface $all,
        ExportTranslationInterface $export,
        array $locales = null
    );

    /**
     * @param FindTranslationInterface $find
     * @param ImportTranslationInterface $import
     * @param string $path
     * @param string $locale
     * @return mixed
     */
    public static function import(
        FindTranslationInterface $find,
        ImportTranslationInterface $import,
        string $path,
        string $locale = ''
    );

    /**
     * @param array $array
     * @return mixed
     */
    public static function fromArray(array $array);
}
