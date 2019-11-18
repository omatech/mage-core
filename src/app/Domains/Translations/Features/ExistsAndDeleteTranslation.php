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
     */
    public function __construct()
    {
        $this->exists = new ExistsTranslation();
        $this->delete = new DeleteTranslation();
    }

    /**
     * @param Translation $translation
     * @return bool
     * @throws TranslationDoesNotExistsException
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
