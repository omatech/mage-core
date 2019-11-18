<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationAlreadyExistsException;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationDoesNotExistsException;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationExistsMustBeUniqueException;
use Omatech\Mage\Core\Domains\Translations\Jobs\CreateTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\ExistsTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\UniqueTranslation;
use Omatech\Mage\Core\Domains\Translations\Jobs\UpdateTranslation;
use Omatech\Mage\Core\Domains\Translations\Translation;

class UpdateOrCreateTranslation
{
    private $create;
    private $update;
    private $exists;
    private $unique;

    /**
     * UpdateOrCreateTranslation constructor.
     */
    public function __construct()
    {
        $this->create = new CreateTranslation();
        $this->update = new UpdateTranslation();
        $this->exists = new ExistsTranslation();
        $this->unique = new UniqueTranslation();
    }

    /**
     * @param Translation $translation
     * @return bool
     * @throws TranslationAlreadyExistsException
     * @throws TranslationDoesNotExistsException
     * @throws TranslationExistsMustBeUniqueException
     */
    public function make(Translation $translation): bool
    {
        if (null !== $translation->getId()) {
            return $this->update($translation);
        }

        return $this->create($translation);
    }

    /**
     * @param Translation $translation
     * @return bool
     * @throws TranslationAlreadyExistsException
     */
    private function create(Translation $translation): bool
    {
        $exists = $this->exists->make($translation);

        if (true === $exists) {
            throw new TranslationAlreadyExistsException();
        }

        return $this->create->make($translation);
    }

    /**
     * @param Translation $translation
     * @return bool
     * @throws TranslationDoesNotExistsException
     * @throws TranslationExistsMustBeUniqueException
     */
    private function update(Translation $translation): bool
    {
        $exists = $this->unique->make($translation);

        if (true === $exists) {
            throw new TranslationExistsMustBeUniqueException();
        }

        $exists = $this->exists->make($translation);

        if (false === $exists) {
            throw new TranslationDoesNotExistsException();
        }

        return $this->update->make($translation);
    }
}
