<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationDoesNotExistsException;
use Omatech\Mage\Core\Domains\Translations\Jobs\FindTranslation;
use Omatech\Mage\Core\Domains\Translations\Translation;

class FindOrFailTranslation
{
    private $find;

    /**
     * FindOrFailTranslation constructor.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->find = app()->make(FindTranslation::class);
    }

    /**
     * @param int $id
     *
     * @throws TranslationDoesNotExistsException
     *
     * @return Translation
     */
    public function make(int $id): Translation
    {
        $translation = $this->find->make($id);

        if (null === $translation) {
            throw new TranslationDoesNotExistsException();
        }

        return $translation;
    }
}
