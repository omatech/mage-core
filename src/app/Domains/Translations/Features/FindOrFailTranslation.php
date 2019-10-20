<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Translations\Jobs\FindTranslation;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationDoesNotExistsException;

class FindOrFailTranslation
{
    private $find;

    /**
     * FindOrFailTranslation constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->find = app()->make(FindTranslation::class);
    }

    /**
     * @param int $id
     * @return Translation
     * @throws TranslationDoesNotExistsException
     */
    public function make(int $id): Translation
    {
        $translation = $this->find->make($id);

        if ($translation === null) {
            throw new TranslationDoesNotExistsException;
        }

        return $translation;
    }
}
