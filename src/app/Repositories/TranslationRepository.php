<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Illuminate\Support\Facades\DB;
use Omatech\Mage\Core\Models\LanguageLine;
use Omatech\Mage\Core\Events\Translations\TranslationCreated;
use Omatech\Mage\Core\Events\Translations\TranslationDeleted;
use Omatech\Mage\Core\Events\Translations\TranslationUpdated;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\CreateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;

class TranslationRepository extends BaseRepository implements
    AllTranslationInterface,
    CreateTranslationInterface,
    DeleteTranslationInterface,
    UpdateTranslationInterface,
    ExistsTranslationInterface,
    UniqueTranslationInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return LanguageLine::class;
    }

    public function get($locales)
    {
        $select = ['id', 'group', 'key'];

        foreach ($locales as $locale) {
            $select[] = "text->$locale as $locale";
        }

        $translations = $this->query()
            ->select($select)
            ->paginate()
            ->toArray();

        return $translations;
    }

    /*public function get($locales)
    {
        $translations = $this->query()
            ->select("group", "key", "text->$lang as value")
            ->get()
            ->toArray();

        $translations = array_map(function ($translation) {
            return [
                'group' => $translation['group'],
                'key'  => $translation['group'] . '.' . $translation['key'],
                'value' => $translation['value']
            ];
        }, $translations);

        return $translations;
    }*/

    public function find(int $id): ?TranslationInterface
    {
        $translation = $this->query()->find($id);

        if ($translation === null) {
            return null;
        }

        $translation = app()->make(TranslationInterface::class)::fromArray([
            'id'           => $translation->id,
            'key'          => $translation->group . '.' . $translation->key,
            'translations' => $translation->text,
            'sync_at'      => $translation->sync_at,
            'created_at'   => $translation->created_at,
            'updated_at'   => $translation->updated_at
        ]);

        return $translation;
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function create(TranslationInterface $translation): bool
    {
        $created = $this->query()->create([
            'group' => $translation->getGroup(),
            'key'   => $translation->getKey(),
            'text'  => $translation->getTranslations(),
            'sync_at' => $translation->getSyncAt()
        ]);

        $translation->setId($created->id);
        $translation->setSyncAt($created->sync_at);
        $translation->setCreatedAt($created->created_at);
        $translation->setUpdatedAt($created->updated_at);

        event(new TranslationCreated($translation, $created->wasRecentlyCreated));

        return $created->wasRecentlyCreated;
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function exists(TranslationInterface $translation): bool
    {
        return $this->query()
            ->where(function ($q) use ($translation) {
                $q->where('group', $translation->getGroup())
                    ->where('key', $translation->getKey());
            })
            ->orWhere('id', $translation->getId())
            ->exists();
    }

    /**
     * @param TranslationInterface $role
     * @return bool
     */
    public function unique(TranslationInterface $translation): bool
    {
        return $this->query()
            ->where('group', $translation->getGroup())
            ->where('key', $translation->getKey())
            ->where('id', '!=', $translation->getId())
            ->exists();
    }

    public function update(TranslationInterface $translation): bool
    {
        $updated = $this->query()->find($translation->getId());

        $updated->fill([
            'group' => $translation->getGroup(),
            'key' => $translation->getKey(),
            'text' => $translation->getTranslations(),
            'sync_at' => $translation->getSyncAt()
        ])->save();

        $translation->setId($updated->id);
        $translation->setCreatedAt($updated->created_at);
        $translation->setUpdatedAt($updated->updated_at);

        event(new TranslationUpdated($translation, count($updated->getChanges()) >= 1));

        return count($updated->getChanges()) >= 1;
    }

    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function delete(TranslationInterface $translation): bool
    {
        $isDeleted = $this->query()
            ->where('id', $translation->getId())
            ->delete();

        $isDeleted = $isDeleted > 0;

        event(new TranslationDeleted($translation, $isDeleted));

        return $isDeleted;
    }
}
