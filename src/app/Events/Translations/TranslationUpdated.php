<?php

namespace Omatech\Mage\Core\Events\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;

class TranslationUpdated
{
    public $translation;
    public $wasUpdated;

    /**
     * TranslationUpdated constructor.
     * @param TranslationInterface $translation
     * @param bool $wasUpdated
     */
    public function __construct(TranslationInterface $translation, bool $wasUpdated)
    {
        $this->role = $translation;
        $this->wasUpdated = $wasUpdated;
    }
}
