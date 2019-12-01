<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Events\Translations\TranslationDeleted;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class DeleteTranslation extends TranslationBaseRepository implements DeleteTranslationInterface
{
    public function delete(TranslationInterface $translation): bool
    {
        $isDeleted = $this->query()
            ->where('id', $translation->getId())
            ->delete();

        event(new TranslationDeleted($translation, $isDeleted > 0));

        return $isDeleted > 0;
    }
}
