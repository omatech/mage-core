<?php

namespace Omatech\Mage\Core\Events\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;

class TranslationCreated
{
    public $translation;
    public $wasRecentlyCreated;

    /**
     * TranslationCreated constructor.
     *
     * @param TranslationInterface $translation
     * @param bool                 $wasRecentlyCreated
     */
    public function __construct(TranslationInterface $translation, bool $wasRecentlyCreated)
    {
        $this->translation = $translation;
        $this->wasRecentlyCreated = $wasRecentlyCreated;
    }
}
