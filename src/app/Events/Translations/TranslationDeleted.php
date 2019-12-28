<?php

namespace Omatech\Mage\Core\Events\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;

class TranslationDeleted
{
    public $translation;
    public $wasDelete;

    /**
     * TranslationDeleted constructor.
     */
    public function __construct(TranslationInterface $translation, bool $wasDelete)
    {
        $this->translation = $translation;
        $this->wasDelete = $wasDelete;
    }
}
