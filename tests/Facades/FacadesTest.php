<?php

namespace Omatech\Mage\Core\Tests\Facades;

use Exception;
use Omatech\Mage\Core\MageFacade as Mage;
use Omatech\Mage\Core\Tests\BaseTestCase;

class FacadesTest extends BaseTestCase
{
    public function testPermissionFacade()
    {
        $permission = $this->createPermission();
        $permissionFacade = Mage::domain('Permission');

        $found = $permissionFacade::find($permission->getId());

        $this->assertTrue($found->getId() == $permission->getId());
    }

    public function testRoleFacade()
    {
        $role = $this->createRole();
        $roleFacade = Mage::domain('Role');

        $found = $roleFacade::find($role->getId());

        $this->assertTrue($found->getId() == $role->getId());
    }

    public function testUserFacade()
    {
        $user = $this->createUser();
        $userFacade = Mage::domain('User');

        $found = $userFacade::find($user->getId());

        $this->assertTrue($found->getId() == $user->getId());
    }

    public function testTranslationFacade()
    {
        $translation = $this->createTranslation();
        $translationFacade = Mage::domain('Translation');

        $found = $translationFacade::find($translation->getGroup().'.'.$translation->getKey());

        $this->assertTrue($found->getId() == $translation->getId());
    }

    public function testNotFoundFacade()
    {
        $this->expectException(Exception::class);
        Mage::domain('notValidFacade');
    }
}
