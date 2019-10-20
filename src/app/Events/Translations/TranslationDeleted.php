<?php

namespace Omatech\Mage\Core\Events\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;

class TranslationDeleted
{
    public $translation;
    public $wasDelete;

    /**
     * TranslationDeleted constructor.
     * @param TranslationInterface $translation
     * @param bool $wasDelete
     */
    public function __construct(TranslationInterface $translation, bool $wasDelete)
    {
        $this->role = $translation;
        $this->wasDelete = $wasDelete;
    }
}
