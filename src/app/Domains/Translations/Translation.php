<?php

namespace Omatech\Mage\Core\Domains\Translations;

use Omatech\Mage\Core\Domains\Shared\Traits\FromArray;
use Omatech\Mage\Core\Domains\Translations\Jobs\AllTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\ExportTranslation;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Features\FindOrFailTranslation;
use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Features\UpdateOrCreateTranslation;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Features\ExistsAndDeleteTranslation;

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
     * @return Translation
     */
    public function setId(int $id): self
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
     * @return Translation
     */
    public function setKey(string $key): self
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
     * @return $this
     */
    public function setTranslation(string $language, string $text): self
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
     * @return $this
     */
    public function setTranslations(array $translations): self
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
            if (!array_key_exists($locale['locale'], $locales)) {
                $locales[] = $locale['locale'];
            }
        }

        return $locales;
    }

    /**
     *
     */
    private function setMissingTranslations(): void
    {
        foreach (static::getLocales() as $locale) {
            if (!array_key_exists($locale, $this->getTranslations())) {
                $this->setTranslation($locale, $this->getGroup() . '.' . $this->getKey());
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
     * @param string $syncAt
     * @return Translation
     */
    public function setSyncAt(?string $syncAt): self
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
     * @return Translation
     */
    public function setCreatedAt(string $createdAt): self
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
     * @return Translation
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param AllTranslationInterface $all
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function all(AllTranslationInterface $all)
    {
        return app()->make(AllTranslation::class)
            ->make($all, static::getLocales());
    }

    /**
     * @param int $id
     * @return Translation
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function find(int $id): self
    {
        return app()->make(FindOrFailTranslation::class)->make($id);
    }

    /**
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function save(): bool
    {
        $this->setMissingTranslations();

        return app()->make(UpdateOrCreateTranslation::class)->make($this);
    }

    /**
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function delete(): bool
    {
        return app()->make(ExistsAndDeleteTranslation::class)->make($this);
    }

    /**
     * @param AllTranslationInterface $allTranslationInterface
     * @param ExportTranslationInterface $exportTranslationInterface
     * @param array|null $locales
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function export(
        AllTranslationInterface $allTranslationInterface,
        ExportTranslationInterface $exportTranslationInterface,
        array $locales = null
    ) {
        $locales = $locales ?? static::getLocales();

        return app()->make(ExportTranslation::class)
            ->make($allTranslationInterface, $exportTranslationInterface, $locales);
    }
}
