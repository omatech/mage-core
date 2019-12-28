<?php

namespace Omatech\Mage\Core\Tests\Facades;

use Exception;
use Omatech\Mage\Core\Domains\Permissions\Permission;
use Omatech\Mage\Core\Domains\Roles\Role;
use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Mage;
use Omatech\Mage\Core\Tests\BaseTestCase;

class FacadesTest extends BaseTestCase
{
    public function testPermissionFacade()
    {
        $permissionFacade = Mage::domain('Permissions');

        $this->assertTrue(Permission::class == get_class($permissionFacade));
    }

    public function testRoleFacade()
    {
        $roleFacade = Mage::domain('Roles');

        $this->assertTrue(Role::class == get_class($roleFacade));
    }

    public function testUserFacade()
    {
        $userFacade = Mage::domain('Users');

        $this->assertTrue(User::class == get_class($userFacade));
    }

    public function testTranslationFacade()
    {
        $translationFacade = Mage::domain('Translations');

        $this->assertTrue(Translation::class == get_class($translationFacade));
    }

    public function testNotFoundFacade()
    {
        $this->expectException(Exception::class);
        Mage::domain('notValidFacade');
    }
}
