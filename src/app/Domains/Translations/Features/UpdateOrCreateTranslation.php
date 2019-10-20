<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Translations\Jobs\CreateTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\ExistsTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\UniqueTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\UpdateTranslation;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationAlreadyExistsException;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationDoesNotExistsException;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationExistsMustBeUniqueException;

class UpdateOrCreateTranslation
{
    private $exists;

    /**
     * UpdateOrCreateTranslation constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->create = app()->make(CreateTranslation::class);
        $this->update = app()->make(UpdateTranslation::class);
        $this->exists = app()->make(ExistsTranslation::class);
        $this->unique = app()->make(UniqueTranslation::class);
    }


    public function make(Translation $translation): bool
    {
        if ($translation->getId() !== null) {
            return $this->update($translation);
        }

        return $this->create($translation);
    }

    private function create(Translation $translation): bool
    {
        $exists = $this->exists->make($translation);

        if ($exists === true) {
            throw new TranslationAlreadyExistsException;
        }

        return $this->create->make($translation);
    }

    private function update(Translation $translation): bool
    {
        $exists = $this->unique->make($translation);

        if ($exists === true) {
            throw new TranslationExistsMustBeUniqueException;
        }

        $exists = $this->exists->make($translation);

        if ($exists === false) {
            throw new TranslationDoesNotExistsException;
        }

        return $this->update->make($translation);
    }
}
