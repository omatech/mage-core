<?php

namespace Omatech\Mage\Core\Events\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;

class TranslationUpdated
{
    public $translation;
    public $wasUpdated;

    /**
     * TranslationUpdated constructor.
     */
    public function __construct(TranslationInterface $translation, bool $wasUpdated)
    {
        $this->translation = $translation;
        $this->wasUpdated = $wasUpdated;
    }
}
