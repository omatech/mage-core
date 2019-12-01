<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\CreateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Events\Translations\TranslationCreated;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class CreateTranslation extends TranslationBaseRepository implements CreateTranslationInterface
{
    public function create(TranslationInterface $translation): bool
    {
        $created = $this->query()->create([
            'group'   => $translation->getGroup(),
            'key'     => $translation->getKey(),
            'text'    => $translation->getTranslations(),
            'sync_at' => $translation->getSyncAt(),
        ]);

        $translation->setId($created->id);
        $translation->setSyncAt($created->sync_at);
        $translation->setCreatedAt($created->created_at);
        $translation->setUpdatedAt($created->updated_at);

        event(new TranslationCreated($translation, $created->wasRecentlyCreated));

        return $created->wasRecentlyCreated;
    }
}
