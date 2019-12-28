<?php

namespace Omatech\Mage\Core\Tests\Domains;

use Omatech\Mage\Core\Adapters\Translations\Exporters\ExporterToArrayFile;
use Omatech\Mage\Core\Adapters\Translations\Exporters\ExporterToExcel;
use Omatech\Mage\Core\Adapters\Translations\GetAllTranslations;
use Omatech\Mage\Core\Adapters\Translations\Importers\ImporterFromExcel;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationAlreadyExistsException;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationDoesNotExistsException;
use Omatech\Mage\Core\Domains\Translations\Exceptions\TranslationExistsMustBeUniqueException;
use Omatech\Mage\Core\Events\Translations\TranslationCreated;
use Omatech\Mage\Core\Events\Translations\TranslationDeleted;
use Omatech\Mage\Core\Events\Translations\TranslationUpdated;
use Omatech\Mage\Core\Repositories\Translations\AllTranslation;
use Omatech\Mage\Core\Repositories\Translations\FindTranslation;
use Omatech\Mage\Core\Tests\BaseTestCase;

class TranslationsTest extends BaseTestCase
{
    public function testPaginateToArrayTranslation(): void
    {
        $pagination = resolve(TranslationInterface::class)::all(new AllTranslation());

        $this->assertTrue(true === is_array($pagination));
    }

    public function testFindTranslation(): void
    {
        $translation = $this->createTranslation();

        $foundTranslation = resolve(TranslationInterface::class)::find(new FindTranslation(), [
            'key' => $translation->getGroup().'.'.$translation->getKey(),
        ]);

        $this->assertTrue($foundTranslation instanceof TranslationInterface);
        $this->assertTrue($translation->getId() === $foundTranslation->getId());
    }

    public function testCreateTranslation(): void
    {
        $this->expectsEvents(TranslationCreated::class);

        $translation = $this->createTranslation();

        $this->assertDatabaseHas(config('translation-loader.table_name'), [
            'group'      => $translation->getGroup(),
            'key'        => $translation->getKey(),
            'text'       => json_encode($translation->getTranslations()),
            'created_at' => $translation->getCreatedAt(),
            'updated_at' => $translation->getUpdatedAt(),
        ]);
    }

    public function testCreateSingleKeyTranslation(): void
    {
        $this->expectsEvents(TranslationCreated::class);

        $translation = $this->createTranslation('test');

        $this->assertDatabaseHas(config('translation-loader.table_name'), [
            'group'      => $translation->getGroup(),
            'key'        => $translation->getKey(),
            'text'       => json_encode($translation->getTranslations()),
            'created_at' => $translation->getCreatedAt(),
            'updated_at' => $translation->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnCreateTranslation(): void
    {
        $this->expectException(TranslationAlreadyExistsException::class);

        $this->createTranslation('mage.test.translation');
        $this->createTranslation('mage.test.translation');
    }

    public function testUpdateTranslation(): void
    {
        $this->expectsEvents(TranslationUpdated::class);

        $translation = $this->createTranslation();
        $translation->setKey('mage.test.translation2');

        $result = $translation->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseHas(config('translation-loader.table_name'), [
            'group'      => $translation->getGroup(),
            'key'        => $translation->getKey(),
            'text'       => json_encode($translation->getTranslations()),
            'created_at' => $translation->getCreatedAt(),
            'updated_at' => $translation->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnUpdateTranslation(): void
    {
        $this->expectException(TranslationExistsMustBeUniqueException::class);

        $translation = $this->createTranslation();

        $translation2 = $this->createTranslation();
        $translation2->setKey($translation->getGroup().'.'.$translation->getKey());
        $translation2->setTranslations($translation->getTranslations());

        $result = $translation2->save();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);
    }

    public function testDeleteTranslation(): void
    {
        $this->expectsEvents(TranslationDeleted::class);

        $translation = $this->createTranslation();

        $this->assertTrue(is_int($translation->getId()));
        $this->assertTrue(null !== $translation->getId());

        $result = $translation->delete();

        $this->assertTrue(true === is_bool($result));
        $this->assertTrue(true === $result);

        $this->assertDatabaseMissing(config('translation-loader.table_name'), [
            'group'      => $translation->getGroup(),
            'key'        => $translation->getKey(),
            'text'       => json_encode($translation->getTranslations()),
            'created_at' => $translation->getCreatedAt(),
            'updated_at' => $translation->getUpdatedAt(),
        ]);
    }

    public function testExceptionOnDeleteTranslation(): void
    {
        $this->expectException(TranslationDoesNotExistsException::class);

        $translation = $this->createTranslation();

        $translation->delete();
        $translation->delete();
    }

    public function testExceptionOnUpdateDeletedTranslation()
    {
        $this->expectException(TranslationDoesNotExistsException::class);

        $permission = $this->createTranslation();
        $permission->delete();

        $permission->setKey('key');
        $permission->save();
    }

    public function testExportToExcelTranslation()
    {
        $this->createTranslation();
        $this->createTranslation();
        $this->createTranslation();

        $translation = resolve(TranslationInterface::class);

        $path = $translation::export(new GetAllTranslations(), new ExporterToExcel());

        $this->assertFileExists($path);
    }

    public function testExportToLaravelArrayTranslation()
    {
        $this->createTranslation();
        $this->createTranslation();
        $this->createTranslation();

        $translation = resolve(TranslationInterface::class);

        $path = $translation::export(new GetAllTranslations(), new ExporterToArrayFile());

        $this->assertFileExists($path);
    }

    public function testImportLanguageFromExcelsTranslations()
    {
        $translation = resolve(TranslationInterface::class);

        $result = $translation::import(
            new FindTranslation(),
            new ImporterFromExcel(),
            __DIR__.'/../stubs/stub.xlsx'
        );

        $this->assertTrue($result);
    }

    public function testImportSingleExistingLanguageFromExcelsTranslations()
    {
        $translation = resolve(TranslationInterface::class);

        $result = $translation::import(
            new FindTranslation(),
            new ImporterFromExcel(),
            __DIR__.'/../stubs/stub.xlsx',
            'ca'
        );

        $this->assertTrue($result);
    }

    public function testImportSingleNotExistingLanguageFromExcelsTranslations()
    {
        $translation = resolve(TranslationInterface::class);

        $result = $translation::import(
            new FindTranslation(),
            new ImporterFromExcel(),
            __DIR__.'/../stubs/stub.xlsx',
            'jp'
        );

        $this->assertTrue($result);
    }
}
