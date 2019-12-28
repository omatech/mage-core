<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;
use Omatech\Mage\Core\Events\Translations\TranslationUpdated;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class UpdateTranslation extends TranslationBaseRepository implements UpdateTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function update(TranslationInterface $translation): bool
    {
        $updated = $this->query()->find($translation->getId());

        $updated->fill([
            'group'   => $translation->getGroup(),
            'key'     => $translation->getKey(),
            'text'    => $translation->getTranslations(),
            'sync_at' => $translation->getSyncAt(),
        ])->save();

        $translation->setId($updated->id);
        $translation->setCreatedAt($updated->created_at);
        $translation->setUpdatedAt($updated->updated_at);

        event(new TranslationUpdated($translation, count($updated->getChanges()) >= 1));

        return count($updated->getChanges()) >= 1;
    }
}
