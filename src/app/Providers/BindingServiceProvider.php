<?php

namespace Omatech\Mage\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Omatech\Mage\Core\Providers\Bindings\PermissionsBindingTrait;
use Omatech\Mage\Core\Providers\Bindings\RolesBindingTrait;
use Omatech\Mage\Core\Providers\Bindings\TranslationsBindingTrait;
use Omatech\Mage\Core\Providers\Bindings\UsersBindingTrait;

class BindingServiceProvider extends ServiceProvider
{
    use PermissionsBindingTrait;
    use RolesBindingTrait;
    use TranslationsBindingTrait;
    use UsersBindingTrait;

    public function boot()
    {
        $this->rolesBindings();
        $this->permissionBindings();
        $this->translationBindings();
        $this->userBindings();
    }
}
