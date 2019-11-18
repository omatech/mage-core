<?php

namespace Omatech\Mage\Core\Domains\Translations;

use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ImportTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Features\ExistsAndDeleteTranslation;
use Omatech\Mage\Core\Domains\Translations\Features\FindOrFailTranslation;
use Omatech\Mage\Core\Domains\Translations\Features\UpdateOrCreateTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\AllTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\ExportTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\ImportTranslation;

class Translation implements TranslationInterface
{
    use FromArray;

    private $id;
    private $group;
    private $key;
    private $translations = [];
    private $syncAt;
    private $createdAt;
    private $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this|mixed
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return $this|mixed
     */
    public function setKey(string $key)
    {
        $key = explode('.', $key);

        if (count($key) > 1) {
            $this->group = $key[0];
            $this->key = implode('.', array_slice($key, 1));
        } else {
            $this->group = 'single';
            $this->key = $key[0];
        }

        return $this;
    }

    /**
     * @param string $language
     * @param string $text
     * @return $this|mixed
     */
    public function setTranslation(string $language, string $text)
    {
        $this->translations[$language] = $text;

        return $this;
    }

    /**
     * @return array
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * @param array $translations
     * @return $this|mixed
     */
    public function setTranslations(array $translations)
    {
        foreach ($translations as $language => $text) {
            $this->setTranslation($language, $text);
        }

        return $this;
    }

    /**
     * @return array
     */
    private static function getLocales(): array
    {
        $availableLocales = config('mage.translations.available_locales');
        $locales = [];

        foreach ($availableLocales as $locale) {
            if (! array_key_exists($locale['locale'], $locales)) {
                $locales[] = $locale['locale'];
            }
        }

        return $locales;
    }

    /**
     * @return void
     */
    private function setMissingTranslations(): void
    {
        foreach (static::getLocales() as $locale) {
            if (! array_key_exists($locale, $this->getTranslations())) {
                $this->setTranslation($locale, $this->getGroup().'.'.$this->getKey());
            }
        }
    }

    /**
     * @return string
     */
    public function getSyncAt(): ?string
    {
        return $this->syncAt;
    }

    /**
     * @param string|null $syncAt
     * @return $this|mixed
     */
    public function setSyncAt(?string $syncAt)
    {
        $this->syncAt = $syncAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this|mixed
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     * @return $this|mixed
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param AllTranslationInterface $all
     * @return mixed
     */
    public static function all(AllTranslationInterface $all)
    {
        return (new AllTranslation)
            ->make($all, static::getLocales());
    }

    /**
     * @param string $key
     * @return static
     */
    public static function find(string $key): self
    {
        return (new FindOrFailTranslation)->make($key);
    }

    /**
     * @return bool
     * @throws Exceptions\TranslationAlreadyExistsException
     * @throws Exceptions\TranslationDoesNotExistsException
     * @throws Exceptions\TranslationExistsMustBeUniqueException
     */
    public function save(): bool
    {
        $this->setMissingTranslations();

        return (new UpdateOrCreateTranslation)->make($this);
    }

    /**
     * @return bool
     * @throws Exceptions\TranslationDoesNotExistsException
     */
    public function delete(): bool
    {
        return (new ExistsAndDeleteTranslation)->make($this);
    }

    /**
     * @param AllTranslationInterface $allTranslationInterface
     * @param ExportTranslationInterface $exportTranslationInterface
     * @param array|null $locales
     * @return string
     */
    public static function export(
        AllTranslationInterface $allTranslationInterface,
        ExportTranslationInterface $exportTranslationInterface,
        array $locales = null
    ) {
        $locales = $locales ?? static::getLocales();

        return (new ExportTranslation)
            ->make($allTranslationInterface, $exportTranslationInterface, $locales);
    }

    /**
     * @param ImportTranslationInterface $importTranslationInterface
     * @param string $path
     * @param string $locale
     * @return bool
     */
    public static function import(
        ImportTranslationInterface $importTranslationInterface,
        string $path,
        string $locale = ''
    ) {
        return (new ImportTranslation)
            ->make($importTranslationInterface, $path, $locale);
    }
}
