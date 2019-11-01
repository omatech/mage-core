<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationDoesNotExistsException;
use Omatech\Mage\Core\Domains\Translations\Jobs\DeleteTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\ExistsTranslation;
use Omatech\Mage\Core\Domains\Translations\Translation;

class ExistsAndDeleteTranslation
{
    private $exists;
    private $delete;

    /**
     * ExistsAndDeleteTranslation constructor.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->exists = app()->make(ExistsTranslation::class);
        $this->delete = app()->make(DeleteTranslation::class);
    }

    /**
     * @param Translation $translation
     *
     * @throws TranslationDoesNotExistsException
     *
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        $exists = $this->exists->make($translation);

        if (false === $exists) {
            throw new TranslationDoesNotExistsException();
        }

        return $this->delete->make($translation);
    }
}
