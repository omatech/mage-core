<?php

namespace Omatech\Mage\Core\Repositories;

use Illuminate\Support\Facades\DB;
use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\CreateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;
use Omatech\Mage\Core\Events\Translations\TranslationCreated;
use Omatech\Mage\Core\Events\Translations\TranslationDeleted;
use Omatech\Mage\Core\Events\Translations\TranslationUpdated;
use Omatech\Mage\Core\Models\LanguageLine;

class TranslationRepository extends BaseRepository implements AllTranslationInterface, CreateTranslationInterface, DeleteTranslationInterface, UpdateTranslationInterface, ExistsTranslationInterface, UniqueTranslationInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return LanguageLine::class;
    }

    /**
     * @param $locales
     *
     * @return mixed
     */
    public function get($locales)
    {
        $select = ['id', 'group', 'key'];

        foreach ($locales as $locale) {
            $select[] = "text->$locale as $locale";
        }

        return $this->query()
            ->select($select)
            ->paginate()
            ->toArray();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function find(string $key)
    {
        $translation = $this->query()
            ->where(DB::raw("CONCAT(`group`, '.', `key`)"), $key)
            ->first();

        if (null === $translation) {
            return app()->make(TranslationInterface::class)::fromArray([
                'key' => $key,
            ]);
        }

        $translation = app()->make(TranslationInterface::class)::fromArray([
            'id'           => $translation->id,
            'key'          => $translation->group.'.'.$translation->key,
            'translations' => $translation->text,
            'sync_at'      => $translation->sync_at,
            'created_at'   => $translation->created_at,
            'updated_at'   => $translation->updated_at,
        ]);

        return $translation;
    }

    /**
     * @param TranslationInterface $translation
     * @return bool
     */
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

    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function exists(TranslationInterface $translation): bool
    {
        return $this->query()
            ->where(static function ($q) use ($translation) {
                $q->where('group', $translation->getGroup())
                    ->where('key', $translation->getKey());
            })
            ->orWhere('id', $translation->getId())
            ->exists();
    }

    /**
     * @param TranslationInterface $translation
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
